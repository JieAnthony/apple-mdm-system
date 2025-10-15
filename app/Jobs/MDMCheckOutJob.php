<?php

namespace App\Jobs;

use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class MDMCheckOutJob implements ShouldQueue
{
    use Dispatchable, \Illuminate\Bus\Queueable, InteractsWithQueue;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $params) {}

    /**
     * Execute the job.
     */
    public function handle(DeviceService $deviceService): void
    {
        $params = $this->params;
        $deviceService->checkout(
            Device::query()->where('udid', $params['udid'])->firstOrFail()
        );
    }
}
