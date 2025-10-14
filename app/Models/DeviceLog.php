<?php

namespace App\Models;

use App\Enums\DeviceLogStateEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $device_id
 * @property DeviceLogStateEnum $state
 * @property string $content
 * @property string|null $command_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $response_at
 * @property-read \App\Models\Device|null $device
 *
 * @method static \Database\Factories\DeviceLogFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereCommandUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereResponseAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceLog whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class DeviceLog extends Model
{
    use HasFactory;

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
