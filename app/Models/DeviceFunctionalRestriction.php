<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceFunctionalRestriction extends Model
{
    protected $table = 'device_functional_restrictions';

    protected $fillable = [
        'device_id',
        'name',
        'key',
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
}
