<?php

namespace App\Listeners;

use App\Events\DeviceJoinedEvent;
use App\Services\DeviceService;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeviceAssignDepProfileListener implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(DeviceJoinedEvent $event): void
    {
        app(DeviceService::class)->assignDepProfile($event->device);
    }
}
