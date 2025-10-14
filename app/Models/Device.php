<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $serial_number
 * @property string $udid
 * @property string $name
 * @property bool $in_abm
 * @property bool $supervision
 * @property bool $activation_lock
 * @property bool $lost_mode
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $registered_at
 * @property \Illuminate\Support\Carbon|null $last_active_at
 * @property-read \App\Models\DeviceBypassCode|null $bypassCode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeviceDepProfile> $depProfiles
 * @property-read int|null $dep_profiles_count
 * @property-read \App\Models\DeviceHasFunctionalRestriction|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FunctionalRestriction> $functionalRestrictions
 * @property-read int|null $functional_restrictions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeviceInstalledApplication> $installedApplications
 * @property-read int|null $installed_applications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeviceLog> $logs
 * @property-read int|null $logs_count
 * @property-read \App\Models\DeviceProfile|null $profile
 *
 * @method static \Database\Factories\DeviceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereActivationLock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereInAbm($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereLastActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereLostMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereRegisteredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereSerialNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereSupervision($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereUdid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Device extends Model
{
    use HasFactory;

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
        return $this->hasMany(DeviceLog::class, 'device_id', 'id');
    }

    public function bypassCode()
    {
        return $this->hasOne(DeviceBypassCode::class, 'device_id', 'id');
    }

    public function installedApplications()
    {
        return $this->hasMany(DeviceInstalledApplication::class, 'device_id', 'id');
    }

    public function depProfiles()
    {
        return $this->hasMany(DeviceDepProfile::class, 'device_id', 'id');
    }

    public function profile()
    {
        return $this->hasOne(DeviceProfile::class, 'device_id', 'id');
    }

    public function functionalRestrictions()
    {
        return $this->belongsToMany(
            FunctionalRestriction::class,
            DeviceHasFunctionalRestriction::class,
            'device_id',
            'functional_restrictions_id',
            'id',
            'id'
        )->withPivot('value');
    }
}
