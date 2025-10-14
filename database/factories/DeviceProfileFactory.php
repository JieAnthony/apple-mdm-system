<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Random\Randomizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceProfile>
 */
class DeviceProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_network_tethered' => $this->faker->boolean,
            'device_capacity' => new Randomizer()->getInt(1, 100),
            'available_device_capacity' => new Randomizer()->getInt(1, 100),
            'battery_level' => new Randomizer()->getInt(1, 100),
            'cellular_technology' => 1,
            'device_name' => $this->faker->name(),
            'build_version' => $this->faker->name,
            'eas_device_identifier' => $this->faker->word(),
            'model' => $this->faker->word(),
            'model_name' => $this->faker->word(),
            'model_number' => $this->faker->word(),
            'modem_firmware_version' => $this->faker->word(),
            'os_version' => 'v'.$this->faker->numberBetween(1, 10).'.'.$this->faker->numberBetween(1, 10).'.'.$this->faker->numberBetween(1, 10),
            'product_name' => $this->faker->name,
            'software_update_device_id' => $this->faker->word,
            'supplemental_build_version' => $this->faker->word,
            'wifi_mac' => $this->faker->word,
            'bluetooth_mac' => $this->faker->word,
        ];
    }
}
