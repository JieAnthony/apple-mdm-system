<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeviceBypassCode extends Model
{
    use SoftDeletes;

    protected $table = 'device_bypass_codes';

    protected $fillable = [
        'device_id',
        'code',
        'hash',
        'key',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
