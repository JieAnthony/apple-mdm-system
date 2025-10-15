<?php

namespace App\Services;

use App\Enums\DeviceLogStateEnum;
use App\Models\Device;
use App\Models\DeviceLog;
use Illuminate\Support\Carbon;

class DeviceLogService
{
    public function record(
        Device $device,
        string $content,
        ?string $commandUUID = null,
        DeviceLogStateEnum $deviceLogStateEnum = DeviceLogStateEnum::PENDING,
        ?Carbon $responseAt = null
    ) {

        $deviceLog = new DeviceLog;
        $deviceLog->device_id = $device->id;
        $deviceLog->content = $content;
        $deviceLog->command_uuid = $commandUUID;
        $deviceLog->state = $deviceLogStateEnum;
        $deviceLog->response_at = $responseAt;
        $deviceLog->save();

        return $deviceLog;
    }

    public function getLogByDeviceAndCommandUUID(Device $device, string $commandUUID)
    {
        return DeviceLog::query()
            ->select(['id', 'device_id', 'command_uuid', 'state'])
            ->where('device_id', $device->id)
            ->where('command_uuid', $commandUUID)
            ->first();
    }

    public function operation(DeviceLog $deviceLog, DeviceLogStateEnum $deviceLogStateEnum, Carbon $responseAt)
    {
        $deviceLog->state = $deviceLogStateEnum;
        $deviceLog->response_at = $responseAt;
        $deviceLog->save();

        return $deviceLog;
    }
}
