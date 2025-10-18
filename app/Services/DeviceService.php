<?php

namespace App\Services;

use App\Enums\DeviceLogStateEnum;
use App\Events\DeviceAuthenticatedEvent;
use App\Events\DeviceCheckOutEvent;
use App\Events\DeviceJoinedEvent;
use App\Exceptions\BusinessException;
use App\Models\Device;
use App\Models\DeviceBypassCode;
use App\Models\DeviceDepProfile;
use App\Models\DeviceInstalledApplication;
use App\Models\DeviceProfile;
use App\Models\FunctionalRestriction;
use App\Models\Nano\Command;
use App\Models\Nano\PushCert;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Proget\Apple\ActivationLock\ActivationLockHashGenerator;
use Proget\Apple\ActivationLock\ActivationLockKeyGenerator;
use Proget\Apple\ActivationLock\ActivationLockRandomBytesGenerator;

class DeviceService
{
    public function store(string $serialNumber)
    {
        $lock = Cache::lock('device_store:'.$serialNumber, 30);
        if ($lock->get()) {
            try {
                $device = Device::query()->where('serial_number', $serialNumber)->first();

                $deviceDetailResult = app('dep')->deviceDetail([$serialNumber]);

                if (! isset($deviceDetailResult['devices'][$serialNumber]) || $deviceDetailResult['devices'][$serialNumber]['response_status'] !== 'SUCCESS') {
                    throw new BusinessException('当前设备无法成功访问，请联系管理员');
                }

                $result = $deviceDetailResult['devices'][$serialNumber];

                if ($device) {
                    if ($device->in_abm) {
                        return $device;
                    }
                } else {
                    $device = new Device;
                    $device->serial_number = $result['serial_number'];
                    $device->supervision = false;
                    $device->lost_mode = false;
                }

                $device->name = sprintf('%s(%s)(%s)', $result['model'], $result['color'], $result['description']);
                $device->in_abm = true;
                $device->save();

                app(DeviceLogService::class)->record(
                    $device,
                    '添加设备',
                    deviceLogStateEnum: DeviceLogStateEnum::ACKNOWLEDGED,
                    responseAt: now()
                );

                event(new DeviceJoinedEvent($device));

                return $device;
            } finally {
                $lock->release();
            }
        }

        throw new BusinessException('操作太快请重试！');
    }

    public function assignDepProfile(Device $device)
    {
        // 分配
        app('dep')->assignProfile(config('dep.profile_uuid'), [$device->serial_number]);

        $result = app('dep')->deviceDetail([$device->serial_number]);

        if (! isset($result['devices'][$device->serial_number]) || $result['devices'][$device->serial_number]['response_status'] !== 'SUCCESS') {
            throw new BusinessException('当前设备无法成功访问，请联系管理员');
        }

        $deviceDepDetail = $result['devices'][$device->serial_number];
        // 新增一条记录
        DeviceDepProfile::create([
            'device_id' => $device->id,
            'uuid' => $deviceDepDetail['profile_uuid'],
            'assigned_by_abm_account' => $deviceDepDetail['device_assigned_by'],
            'device_assigned_at' => Carbon::parse($deviceDepDetail['device_assigned_date'])->tz(config('app.timezone')),
        ]);
    }

    public function authenticate(string $rawPayload, Carbon $responseAt)
    {
        $payload = app('plist')->parse(\base64_decode($rawPayload));

        if (! isset($payload['UDID'], $payload['SerialNumber'], $payload['ProductName'])) {
            throw new BusinessException('需要处理的数据不存在');
        }

        $device = Device::query()
            ->where('udid', $payload['UDID'])
            ->first();

        $device->supervision = true;
        $device->lost_mode = false;
        $device->save();

        app(DeviceLogService::class)->record(
            $device,
            '加入监管',
            deviceLogStateEnum: DeviceLogStateEnum::ACKNOWLEDGED,
            responseAt: $responseAt
        );

        event(new DeviceAuthenticatedEvent($device));
    }

    public function connectByIdle(Device $device, Carbon $responseAt)
    {
        if ($device->last_active_at === null || $device->last_active_at->lte($responseAt)) {
            $device->last_active_at = $responseAt;
            $device->save();
        }
    }

    public function connectByAcknowledged(Device $device, string $rawPayload, string $commandUUID, Carbon $responseAt)
    {
        $command = Command::query()
            ->select(['command_uuid', 'request_type'])
            ->where('command_uuid', $commandUUID)
            ->first();
        if (! $command) {
            return;
        }

        $this->connectByIdle($device, $responseAt);

        $deviceLogService = app(DeviceLogService::class);

        $deviceLog = $deviceLogService->getLogByDeviceAndCommandUUID($device, $commandUUID);

        if ($deviceLog) {
            if ($deviceLog->state !== DeviceLogStateEnum::PENDING) {
                return;
            }

            $deviceLogService->operation($deviceLog, DeviceLogStateEnum::ACKNOWLEDGED, $responseAt);
        }

        $method = 'MDMCallbackHandleBy'.$command->request_type;
        if (! \method_exists($this, $method)) {
            // 没有对应方法 则不需要处理
            return;
        }

        $this->{$method}($device, app('plist')->parse(\base64_decode($rawPayload)));
    }

    public function checkout(Device $device)
    {
        $device->is_supervised = false;
        $device->save();

        app(DeviceLogService::class)->record(
            $device,
            '远程管理描述文件被移除',
            deviceLogStateEnum: DeviceLogStateEnum::ACKNOWLEDGED,
            responseAt: now()
        );

        event(new DeviceCheckOutEvent($device));
    }

    public function sendMDMCommand(Device $device, string $plist, ?string $logContent = null)
    {
        if (! $device->udid) {
            throw new BusinessException('发送错误：缺少UDID！');
        }

        $result = app('mdm')->enqueue([$device->udid], $plist);

        if ($logContent) {
            app(DeviceLogService::class)->record(
                $device,
                \sprintf('发送指令：%s', $logContent),
                $result['command_uuid'],
            );
        }

        return $result;
    }

    public function information(Device $device)
    {
        $this->sendMDMCommand(
            $device,
            app('plist')->deviceInformationPlist(),
            '获取设备信息'
        );
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

    public function getInstalledApplicationList(Device $device)
    {
        $this->sendMDMCommand(
            $device,
            app('plist')->installedApplicationListPlist(),
            '获取设备已安装的APP列表'
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

    public function disableActivationLock(Device $device)
    {
        $lock = Cache::lock('device:'.$device->id, 10);
        if ($lock->get()) {
            try {
                $deviceBypassCode = DeviceBypassCode::query()
                    ->select(['id', 'device_id', 'code', 'hash', 'key'])
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

                // 通过推送证书的topic 找出 cert_pem 和 key_pem
                $pushCert = PushCert::query()
                    ->select(['topic', 'cert_pem', 'key_pem'])
                    ->where('topic', config('apple.apns_topic'))
                    ->firstOrFail();

                $certPath = temporaryCertificateGenerate($pushCert->cert_pem);
                $sslKeyPath = temporaryCertificateGenerate($pushCert->key_pem);

                $formParams = [
                    'orgName' => config('apple.org_name'),
                    'guid' => config('apple.guid'),
                    'escrowKey' => $deviceBypassCode->code,
                ];

                $client = new Client;
                $response = $client->post('https://deviceservices-external.apple.com/deviceservicesworkers/escrowKeyUnlock', [
                    RequestOptions::QUERY => $query,
                    RequestOptions::FORM_PARAMS => $formParams,
                    RequestOptions::CERT => $certPath,
                    RequestOptions::SSL_KEY => $sslKeyPath,
                    RequestOptions::HTTP_ERRORS => false,
                ]);

                unlink($certPath);
                unlink($sslKeyPath);

                if ($response->getStatusCode() !== 200) {
                    Log::error('激活锁解锁失败', [
                        'device_id' => $device->id,
                        'query' => $query,
                        'form_params' => $formParams,
                        'response_body' => $response->getBody()->getContents(),
                    ]);
                    throw new BusinessException('解锁失败，请联系管理员');
                }

                $device->activation_lock = false;
                $device->save();

                $deviceBypassCode->device();

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

    public function setFunctionalRestrictions(Device $device, ?array $functionalRestrictionIds = null)
    {
        $functionalRestrictionItems = [];
        if ($functionalRestrictionIds !== null) {
            $functionalRestrictions = FunctionalRestriction::query()
                ->select(['id', 'name', 'key', 'default_value'])
                ->get();
            foreach ($functionalRestrictions as $functionalRestriction) {
                $inIds = \in_array($functionalRestriction->id, $functionalRestrictionIds);
                if (
                    ($functionalRestriction->default_value === true && ! $inIds)
                    || ($functionalRestriction->default_value === false && $inIds)
                ) {
                    $functionalRestrictionItems[$functionalRestriction->key] = ! $functionalRestriction->default_value;
                }
            }
        }

        //
        //        $plistService = app('plist');
        //
        //        $plist = $plistService->generateRestrictionsProfileFile($functionalRestrictionItems);
        //
        //        $this->sendMDMCommand(
        //            $device,
        //            $plistService->installProfilePlist($plist),
        //            '修改功能限制策略',
        //        );

        if (empty($functionalRestrictionItems)) {
            $device->functionalRestrictions()->detach();
        } else {
            $sync = [];
            $newFunctionalRestrictions = FunctionalRestriction::query()
                ->select(['id', 'key'])
                ->whereIn('key', \array_keys($functionalRestrictionItems))
                ->get();
            foreach ($newFunctionalRestrictions as $newFunctionalRestriction) {
                $sync[$newFunctionalRestriction->id] = ['value' => $functionalRestrictionItems[$newFunctionalRestriction->key]];
            }

            $device->functionalRestrictions()->sync($sync);
        }
    }

    public function custom(Device $device, string $plist)
    {
        try {
            $data = app('plist')->parse($plist);
            $requestType = $data['Command']['RequestType'];
        } catch (\Exception $exception) {
            throw new BusinessException('请检查plist是否符合要求！'.$exception->getMessage());
        }

        $this->sendMDMCommand($device, $plist, '自定义指令:'.$requestType);
    }

    public function enrollment(string $content)
    {
        $deviceInfo = $this->parseAppleAspenDeviceInfo($content);

        $lock = Cache::lock('device_enrollment:'.$deviceInfo['Serial']);
        if ($lock->get()) {
            try {
                $device = Device::query()
                    ->select(['id', 'in_abm', 'supervision', 'serial_number'])
                    ->where('serial_number', $deviceInfo['Serial'])
                    ->first();
                if (! $device) {
                    throw new BusinessException('设备不存在');
                }
                if (! $device->in_abm) {
                    throw new BusinessException('当前设备不存在于ABM，请联系管理员检查');
                }

                $device->udid = $deviceInfo['UDID'];
                $device->supervision = true;
                $device->lost_mode = false;
                $device->save();

                app(DeviceLogService::class)->record(
                    $device,
                    '确认注册',
                    deviceLogStateEnum: DeviceLogStateEnum::ACKNOWLEDGED,
                    responseAt: now()
                );

                // 生成一个描述文件 让客户端响应给设备从而进行监管
                $fileName = sprintf('%s.mobileconfig', Str::random(20));
                Storage::disk('public')->put(
                    $fileName,
                    app('plist')->generateDescriptionFile()
                );

                return Storage::disk('public')->path($fileName);
            } finally {
                $lock->release();
            }
        }
        throw new BusinessException('请重试！');
    }

    public function parseAppleAspenDeviceInfo(string $content)
    {
        $content = \str_replace([' '], '+', $content);
        $plistMatch = '/<plist[^>]*?>[\s\S]*?<\/plist>/mi';
        $cmsEnvelope = \base64_decode($content);
        preg_match_all($plistMatch, $cmsEnvelope, $plistData, PREG_SET_ORDER);
        $plist = app('plist')->parse($plistData[0][0]);

        if (! is_array($plist)) {
            throw new BusinessException('解析错误，请联系管理员[no array]');
        }

        if (! isset($plist['UDID'], $plist['SERIAL'])) {
            throw new BusinessException('解析错误，请联系管理员[empty udid or serial]');
        }

        return [
            'UDID' => $plist['UDID'],
            'Serial' => $plist['SERIAL'],
            'IMEI' => $plist['IMEI'] ?? '',
            'Language' => $plist['LANGUAGE'] ?? '',
            'MEID' => $plist['MEID'] ?? '',
            'Product' => $plist['PRODUCT'] ?? '',
            'Version' => $plist['VERSION'] ?? '',
        ];
    }

    /*******************************回调处理*******************************/

    public function MDMCallbackHandleByEnableLostMode(Device $device, array $params)
    {
        $device->lost_mode = true;
        $device->save();
    }

    public function MDMCallbackHandleByDisableLostMode(Device $device, array $params)
    {
        $device->lost_mode = false;
        $device->save();
    }

    public function MDMCallbackHandleByDeviceProfile(Device $device, array $params)
    {
        $result = $params['QueryResponses'];

        if ($device->in_abm) {
            $deviceUpdateData = [];
            if (isset($result['IsSupervised'])) {
                $deviceUpdateData['supervision'] = $result['IsSupervised'];
            }
            if (isset($result['IsMDMLostModeEnabled'])) {
                $deviceUpdateData['lost_mode'] = $result['IsMDMLostModeEnabled'];
            }
            if ($deviceUpdateData) {
                $device->update($deviceUpdateData);
            }
        }

        $deviceProfile = DeviceProfile::query()
            ->where('device_id', $device->id)
            ->first();
        if (! $deviceProfile) {
            $deviceProfile = new DeviceProfile;
            $deviceProfile->device_id = $device->id;
        }
        $serviceSubscriptions = [];
        if (! empty($result['ServiceSubscriptions']) && \is_array($result['ServiceSubscriptions'])) {
            foreach ($result['ServiceSubscriptions'] as $serviceSubscription) {
                $phoneNumber = isset($serviceSubscription['PhoneNumber']) ? \str_replace(' ', '', $serviceSubscription['PhoneNumber']) : '';
                $serviceSubscriptions[] = [
                    'imei' => isset($serviceSubscription['IMEI']) ? \str_replace(' ', '', $serviceSubscription['IMEI']) : '',
                    'meid' => isset($serviceSubscription['MEID']) ? \str_replace(' ', '', $serviceSubscription['MEID']) : '',
                    'slot' => isset($serviceSubscription['Slot']) ? \str_replace(' ', '', $serviceSubscription['Slot']) : '',
                    'iccid' => isset($serviceSubscription['ICCID']) ? \str_replace(' ', '', $serviceSubscription['ICCID']) : '',
                    'phone_number' => $phoneNumber,
                ];
            }
        }
        $version = $result['OSVersion'] ?? '';

        $deviceProfile->is_network_tethered = $result['IsNetworkTethered'] ?? false;
        $deviceProfile->device_capacity = isset($result['DeviceCapacity']) ? (int) $result['DeviceCapacity'] : 0;
        $deviceProfile->available_device_capacity = isset($result['AvailableDeviceCapacity']) ? (int) $result['AvailableDeviceCapacity'] : 0;
        $deviceProfile->battery_level = isset($result['BatteryLevel']) ? (int) ($result['BatteryLevel'] * 100) : 0;
        $deviceProfile->cellular_technology = $result['CellularTechnology'] ?? false;
        $deviceProfile->device_name = $result['DeviceName'] ?? '';
        $deviceProfile->build_version = $result['BuildVersion'] ?? '';
        $deviceProfile->eas_device_identifier = $result['EASDeviceIdentifier'] ?? '';
        $deviceProfile->model = $result['Model'] ?? '';
        $deviceProfile->model_name = $result['ModelName'] ?? '';
        $deviceProfile->model_number = $result['ModelNumber'] ?? '';
        $deviceProfile->modem_firmware_version = $result['ModemFirmwareVersion'] ?? '';
        $deviceProfile->os_version = $version;
        $deviceProfile->product_name = $result['ProductName'] ?? '';
        $deviceProfile->software_update_device_id = $result['SoftwareUpdateDeviceID'] ?? '';
        $deviceProfile->supplemental_build_version = $result['SupplementalBuildVersion'] ?? '';
        $deviceProfile->wifi_mac = $result['WiFiMAC'] ?? '';
        $deviceProfile->bluetooth_mac = $result['BluetoothMAC'] ?? '';
        $deviceProfile->service_subscriptions = $serviceSubscriptions ?: null;
        $deviceProfile->save();
    }

    public function MDMCallbackHandleByInstallProfile(Device $device, array $params)
    {
        $this->sendMDMCommand(
            $device,
            app('plist')->restrictionsPlist(),
        );
    }

    public function MDMCallbackHandleByRestrictions(Device $device, array $params)
    {
        if (! empty($params['GlobalRestrictions']['restrictedBool'])) {
            $device->functionalRestrictions()->detach();

            foreach ($params['GlobalRestrictions']['restrictedBool'] as $key => $value) {
                $functionalRestrictionItems[$key] = $value;
            }
            $functionalRestrictions = FunctionalRestriction::query()
                ->select(['id', 'key'])
                ->whereIn('key', \array_keys($functionalRestrictionItems))
                ->get();

            $functionalRestrictionSync = [];
            foreach ($functionalRestrictions as $functionalRestriction) {
                if (isset($functionalRestrictionItems[$functionalRestriction->key])) {
                    $functionalRestrictionSync[$functionalRestriction->id] = $functionalRestrictionItems[$functionalRestriction->key];
                }
            }

            if ($functionalRestrictionSync) {
                $device->functionalRestrictions()->sync($functionalRestrictionSync);
            }
        }
    }

    public function MDMCallbackHandleByInstalledApplicationList(Device $device, array $params)
    {
        if (! empty($plist['InstalledApplicationList'])) {
            $hasIds = [];
            foreach ($params['InstalledApplicationList'] as $installedApplication) {
                if (! empty($installedApplication['Identifier']) && ! empty($installedApplication['Name'])) {
                    $deviceInstalledApplication = DeviceInstalledApplication::updateOrCreate(
                        [
                            'device_id' => $device->id,
                            'identifier' => $installedApplication['Identifier'],
                        ],
                        [
                            'name' => $installedApplication['Name'] ?? null,
                            'version' => $installedApplication['Version'] ?? null,
                            'short_version' => $installedApplication['ShortVersion'] ?? null,
                            'ad_hoc_code_signed' => $installedApplication['AdHocCodeSigned'] ?? null,
                            'app_store_vendable' => $installedApplication['AppStoreVendable'] ?? null,
                            'beta_app' => $installedApplication['BetaApp'] ?? null,
                            'device_based_vpp' => $installedApplication['DeviceBasedVPP'] ?? null,
                            'has_update_available' => $installedApplication['HasUpdateAvailable'] ?? null,
                            'installing' => $installedApplication['Installing'] ?? null,
                            'is_app_clip' => $installedApplication['IsAppClip'] ?? null,
                            'is_validated' => $installedApplication['IsValidated'] ?? null,
                            'bundle_size' => $installedApplication['BundleSize'] ?? null,
                            'dynamic_size' => $installedApplication['DynamicSize'] ?? null,
                            'external_version_identifier' => $installedApplication['ExternalVersionIdentifier'] ?? null,
                        ]
                    );
                    $hasIds[] = $deviceInstalledApplication->id;
                }
            }

            DeviceInstalledApplication::where('device_id', $device->id)->whereNotIn('id', $hasIds)->delete();
        }
    }
}
