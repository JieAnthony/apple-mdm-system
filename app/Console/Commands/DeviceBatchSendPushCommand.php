<?php

namespace App\Console\Commands;

use App\Jobs\DeviceBatchSendPushJob;
use App\Models\Device;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class DeviceBatchSendPushCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'device:batch-send-push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '设备批量发送推送';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Device::query()
            ->select(['id', 'udid'])
            ->where('supervision', true)
            ->whereNotNull('udid')
            ->chunkById(50, function (Collection $devices) {
                DeviceBatchSendPushJob::dispatch($devices->pluck('udid')->toArray());
            });

        return 0;
    }
}
