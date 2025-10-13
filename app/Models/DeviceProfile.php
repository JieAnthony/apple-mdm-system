<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceProfile extends Model
{
    protected $table = 'device_profiles';

    protected $fillable = [
        'device_id',
        'is_network_tethered',
        'device_capacity',
        'available_device_capacity',
        'battery_level',
        'cellular_technology',
        'device_name',
        'build_version',
        'eas_device_identifier',
        'model',
        'model_name',
        'model_number',
        'modem_firmware_version',
        'os_version',
        'product_name',
        'software_update_device_id',
        'supplemental_build_version',
        'wifi_mac',
        'bluetooth_mac',
        'service_subscriptions',
    ];

    protected $casts = [
        'is_network_tethered' => 'boolean',
        'service_subscriptions' => 'array',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
