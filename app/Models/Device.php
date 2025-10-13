<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $table = 'devices';

    protected $fillable = [
        'serial_number',
        'udid',
        'name',
        'in_abm',
        'supervision',
        'activation_lock',
        'lost_mode',
        'last_active_at',
        'registered_at',
    ];

    protected function casts()
    {
        return [
            'in_abm' => 'boolean',
            'supervision' => 'boolean',
            'activation_lock' => 'boolean',
            'lost_mode' => 'boolean',
            'last_active_at' => 'datetime',
            'registered_at' => 'datetime',
        ];
    }

    public function logs()
    {
        return $this->hasMany(DeviceLog::class,'device_id','id');
    }

    public function bypassCode()
    {
        return $this->hasOne(DeviceBypassCode::class,'device_id','id');
    }

    public function installedApplications()
    {
        return $this->hasMany(DeviceInstalledApplication::class,'device_id','id');
    }

    public function functionalRestrictions()
    {
        return $this->hasMany(DeviceFunctionalRestriction::class,'device_id','id');
    }

    public function depProfiles()
    {
        return $this->hasMany(DeviceDepProfile::class,'device_id','id');
    }
}
