<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceInstalledApplication extends Model
{
    protected $table = 'device_installed_applications';

    protected $fillable = [
        'device_id',
        'identifier',
        'name',
        'version',
        'short_version',
        'ad_hoc_code_signed',
        'app_store_vendable',
        'beta_app',
        'device_based_vpp',
        'has_update_available',
        'installing',
        'is_app_clip',
        'is_validated',
        'bundle_size',
        'dynamic_size',
        'external_version_identifier',
    ];

    protected $casts = [
        'ad_hoc_code_signed' => 'boolean',
        'app_store_vendable' => 'boolean',
        'beta_app' => 'boolean',
        'device_based_vpp' => 'boolean',
        'has_update_available' => 'boolean',
        'installing' => 'boolean',
        'is_app_clip' => 'boolean',
        'is_validated' => 'boolean',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id', 'id');
    }
}
