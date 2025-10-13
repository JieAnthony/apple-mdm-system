<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceDepProfile extends Model
{
    protected $table = 'device_dep_profiles';

    protected $fillable = [
        'device_id',
        'uuid',
        'assigned_by_abm_account',
        'device_assigned_at',
        'profile_assigned_at',
        'profile_pushed_at',
    ];

    protected function casts()
    {
        return [
            'device_assigned_at' => 'datetime',
            'profile_assigned_at' => 'datetime',
            'profile_pushed_at' => 'datetime',
        ];
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
