<?php

namespace App\Jobs;

use App\Services\DeviceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Carbon;

class MDMAuthenticateJob implements ShouldQueue
{
    use Dispatchable,InteractsWithQueue,Queueable;

    public function __construct(public array $params, public string $responseAt) {}

    /**
     * Execute the job.
     */
    public function handle(DeviceService $deviceService): void
    {
        $params = $this->params;
        $deviceService->authenticate(
            $params['raw_payload'],
            Carbon::parse($this->responseAt)->tz(config('app.timezone'))
        );
    }
}
