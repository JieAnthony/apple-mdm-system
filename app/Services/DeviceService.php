<?php

namespace App\Services;

use App\Enums\DeviceLogStateEnum;
use App\Exceptions\BusinessException;
use App\Models\Device;
use App\Models\DeviceBypassCode;
use App\Models\DeviceProfile;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Proget\Apple\ActivationLock\ActivationLockHashGenerator;
use Proget\Apple\ActivationLock\ActivationLockKeyGenerator;
use Proget\Apple\ActivationLock\ActivationLockRandomBytesGenerator;

class DeviceService
{
    public function store(string $serialNumber) {}

    public function sendMDMCommand(Device $device, string $plist, ?string $logContent = null)
    {
        if (! $device->udid) {
            throw new BusinessException('发送错误：缺少UDID！');
        }

        $result = app('mdm')->enqueue([$device->udid], $plist);

        if ($logContent) {
            app(DeviceLogService::class)->record(
                $device,
                \sprintf('下发指令：%s', $logContent),
                $result['command_uuid'],
            );
        }

        return $result;
    }

    public function enableLostMode(Device $device, string $message, string $phoneNumber, string $footNote)
    {
        $this->sendMDMCommand(
            $device,
            app('plist')->enableLostModePlist($message, $phoneNumber, $footNote),
            '开启丢失模式'
        );
    }

    public function disableLostMode(Device $device)
    {
        $this->sendMDMCommand(
            $device,
            app('plist')->disableLostModePlist(),
            '禁用丢失模式'
        );
    }

    public function enableActivationLock(Device $device)
    {
        $lock = Cache::lock('device:'.$device->id, 10);
        if ($lock->get()) {
            try {

                $bytes = (new ActivationLockRandomBytesGenerator)->generate();
                $hash = \strtolower((new ActivationLockHashGenerator)->generate($bytes));
                $code = (new ActivationLockKeyGenerator)->generate($bytes);

                $result = app('dep')->deviceActivationLock($device->serial_number, $hash);
                if (! isset($result['response_status']) || $result['response_status'] !== 'SUCCESS') {
                    throw new BusinessException('开启激活锁失败，更多细节请联系客服！');
                }

                $now = now();

                // 如果请求能成功，将之前的记录设置为无效
                DeviceBypassCode::where('device_id', $device->id)->delete();

                $device->activation_lock = true;
                $device->save();

                $deviceBypassCode = new DeviceBypassCode;
                $deviceBypassCode->device_id = $device->id;
                $deviceBypassCode->code = $code;
                $deviceBypassCode->hash = $hash;
                $deviceBypassCode->key = \bin2hex($bytes->raw());
                $deviceBypassCode->save();

                app(DeviceLogService::class)->record(
                    $device,
                    '开启激活锁',
                    deviceLogStateEnum: DeviceLogStateEnum::ACKNOWLEDGED,
                    responseAt: $now
                );

                return $device;
            } finally {
                $lock->release();
            }
        }

        throw new BusinessException('请重试');
    }

    public function handleActivationLockDisable(Device $device)
    {
        $lock = Cache::lock('device:'.$device->id, 10);
        if ($lock->get()) {
            try {
                $deviceBypassCode = DeviceBypassCode::query()
                    ->select(['id', 'device_id', 'available', 'code', 'hash', 'key'])
                    ->where('device_id', $device->id)
                    ->first();

                if (! $deviceBypassCode || empty($deviceBypassCode->code)) {
                    throw new BusinessException('激活锁绕过代码数据不存在');
                }

                $deviceProfile = DeviceProfile::query()
                    ->select(['id', 'service_subscriptions', 'product_name', 'device_id', 'model_name'])
                    ->where('device_id', $device->id)
                    ->first();

                if (! $deviceProfile || empty($deviceProfile->product_name)) {
                    throw new BusinessException('设备信息不完整，请联系管理员');
                }

                $query = [
                    'serial' => $device->serial_number,
                    'productType' => $deviceProfile->model_name,
                ];
                if ($deviceProfile->service_subscriptions) {
                    foreach ($deviceProfile->service_subscriptions as $index => $serviceSubscription) {
                        if ($index === 0) {
                            if (! empty($serviceSubscription['imei'])) {
                                $query['imei'] = $serviceSubscription['imei'];
                            }
                            if (! empty($serviceSubscription['meid'])) {
                                $query['meid'] = $serviceSubscription['meid'];
                            }
                        }
                        if ($index === 1) {
                            if (! empty($serviceSubscription['imei'])) {
                                $query['imei2'] = $serviceSubscription['imei'];
                            }
                        }
                    }
                }

                $formParams = [
                    'orgName' => config('apple.org_name'),
                    'guid' => config('apple.guid'),
                    'escrowKey' => $deviceBypassCode->code,
                ];

                $client = new Client;
                $response = $client->post('https://deviceservices-external.apple.com/deviceservicesworkers/escrowKeyUnlock', [
                    RequestOptions::QUERY => $query,
                    RequestOptions::FORM_PARAMS => $formParams,
                    RequestOptions::CERT => storage_path('/app/certs/push/cert.pem'),
                    RequestOptions::SSL_KEY => storage_path('/app/certs/push/key.pem'),
                    RequestOptions::HTTP_ERRORS => false,
                ]);
                if ($response->getStatusCode() !== 200) {
                    Log::error('激活锁解锁失败', [
                        'device_id' => $device->id,
                        'query' => $query,
                        'form_params' => $formParams,
                        'response_body' => $response->getBody()->getContents(),
                    ]);
                    throw new BusinessException('解锁失败，请联系管理员');
                }

                $device->enable_activation_lock = false;
                $device->save();

                $deviceBypassCode->available = false;
                $deviceBypassCode->save();

                app(DeviceLogService::class)->record(
                    $device,
                    '关闭激活锁',
                    deviceLogStateEnum: DeviceLogStateEnum::ACKNOWLEDGED,
                    responseAt: now()
                );

                return $device;
            } finally {
                $lock->release();
            }
        }

        throw new BusinessException('请重试');
    }
}
