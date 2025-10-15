<?php

namespace App\Jobs;

use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class MDMConnectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $params, public string $responseAt) {}

    /**
     * Execute the job.
     */
    public function handle(DeviceService $deviceService): void
    {
        $params = $this->params;

        $device = Device::query()->where('udid', $params['udid'])->firstOrFail();

        $responseAt = Carbon::parse($this->responseAt)->tz(config('app.timezone'));

        if ($params['status'] === 'Idle') {
            // 修改设备的 last_active_at 时间
            $deviceService->connectByIdle($device, $responseAt);
        }

        if ($params['status'] === 'Acknowledged') {
            $deviceService->connectByAcknowledged(
                $device,
                $params['raw_payload'],
                $params['command_uuid'],
                $responseAt,
            );
        }
    }
}
