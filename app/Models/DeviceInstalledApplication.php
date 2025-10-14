<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $device_id
 * @property string $identifier
 * @property string $name
 * @property string|null $version
 * @property string|null $short_version
 * @property bool|null $ad_hoc_code_signed
 * @property bool|null $app_store_vendable
 * @property bool|null $beta_app
 * @property bool|null $device_based_vpp
 * @property bool|null $has_update_available
 * @property bool|null $installing
 * @property bool|null $is_app_clip
 * @property bool|null $is_validated
 * @property int|null $bundle_size
 * @property int|null $dynamic_size
 * @property int|null $external_version_identifier
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 *
 * @method static \Database\Factories\DeviceInstalledApplicationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereAdHocCodeSigned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereAppStoreVendable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereBetaApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereBundleSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereDeviceBasedVpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereDynamicSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereExternalVersionIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereHasUpdateAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereInstalling($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereIsAppClip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereIsValidated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereShortVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceInstalledApplication whereVersion($value)
 *
 * @mixin \Eloquent
 */
class DeviceInstalledApplication extends Model
{
    use HasFactory;

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
