<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $device_id
 * @property bool|null $is_network_tethered
 * @property int|null $device_capacity
 * @property int|null $available_device_capacity
 * @property int|null $battery_level
 * @property int|null $cellular_technology
 * @property string|null $device_name
 * @property string|null $build_version
 * @property string|null $eas_device_identifier
 * @property string|null $model
 * @property string|null $model_name
 * @property string|null $model_number
 * @property string|null $modem_firmware_version
 * @property string|null $os_version
 * @property string|null $product_name
 * @property string|null $software_update_device_id
 * @property string|null $supplemental_build_version
 * @property string|null $wifi_mac
 * @property string|null $bluetooth_mac
 * @property array<array-key, mixed>|null $service_subscriptions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 *
 * @method static \Database\Factories\DeviceProfileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereAvailableDeviceCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereBatteryLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereBluetoothMac($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereBuildVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereCellularTechnology($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereDeviceCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereDeviceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereEasDeviceIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereIsNetworkTethered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereModelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereModelNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereModemFirmwareVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereOsVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereServiceSubscriptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereSoftwareUpdateDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereSupplementalBuildVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DeviceProfile whereWifiMac($value)
 *
 * @mixin \Eloquent
 */
class DeviceProfile extends Model
{
    use HasFactory;

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
