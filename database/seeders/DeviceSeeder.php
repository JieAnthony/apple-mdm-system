<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\DeviceInstalledApplication;
use App\Models\DeviceLog;
use App\Models\DeviceProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Device::factory()
            ->count(100)
            ->has(DeviceProfile::factory()->count(1), 'profile')
            ->has(DeviceLog::factory()->count(100), 'logs')
            ->has(DeviceInstalledApplication::factory()->count(20), 'installedApplications')
            ->create();
    }
}
