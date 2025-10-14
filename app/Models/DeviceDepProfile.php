<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $device_id
 * @property string|null $uuid
 * @property string|null $assigned_by_abm_account
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $device_assigned_at
 * @property \Illuminate\Support\Carbon|null $profile_assigned_at
 * @property \Illuminate\Support\Carbon|null $profile_pushed_at
 * @property-read \App\Models\Device|null $device
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereAssignedByAbmAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereDeviceAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereProfileAssignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereProfilePushedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceDepProfile whereUuid($value)
 *
 * @mixin \Eloquent
 */
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
