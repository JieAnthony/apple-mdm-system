<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class DeviceBatchGetInformationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public array $udidItems) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app('mdm')->enqueue(
            $this->udidItems,
            app('plist')->deviceInformationPlist()
        );
    }
}
