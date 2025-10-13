<?php

namespace App\Models;

use App\Enums\DeviceLogStateEnum;
use Illuminate\Database\Eloquent\Model;

class DeviceLog extends Model
{
    protected $table = 'device_logs';

    protected $fillable = [
        'device_id',
        'state',
        'content',
        'command_uuid',
        'response_at',
    ];

    protected function casts()
    {
        return [
            'state' => DeviceLogStateEnum::class,
            'response_at' => 'datetime',
        ];
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
