<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// 每奇数小时，所有设备推送消息通知
Schedule::command('device:batch-send-push')
    ->cron('0 1-23/2 * * *')
    ->evenInMaintenanceMode();

// 每偶数小时 所有设备更新信息
Schedule::command('device:batch-get-information')
    ->cron('0 0-22/2 * * *')
    ->evenInMaintenanceMode();
