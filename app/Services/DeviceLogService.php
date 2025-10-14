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
}
