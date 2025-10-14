<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $device_id
 * @property string $code
 * @property string $hash
 * @property string $key
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Device|null $device
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceBypassCode withoutTrashed()
 *
 * @mixin \Eloquent
 */
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
