<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property-read \App\Models\Device|null $device
 * @property-read \App\Models\FunctionalRestriction|null $functionalRestriction
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceHasFunctionalRestriction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceHasFunctionalRestriction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceHasFunctionalRestriction query()
 *
 * @mixin \Eloquent
 */
class DeviceHasFunctionalRestriction extends Pivot
{
    protected $table = 'device_functional_restrictions';

    protected $fillable = [
        'device_id',
        'functional_restriction_id',
        'value',
    ];

    protected function casts()
    {
        return [
            'value' => 'boolean',
        ];
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }

    public function functionalRestriction()
    {
        return $this->belongsTo(FunctionalRestriction::class, 'functional_restriction_id', 'id');
    }
}
