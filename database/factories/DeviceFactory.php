<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Device>
 */
class DeviceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial_number' => $this->faker->unique()->userName(),
            'udid' => $this->faker->unique()->userName(),
            'name' => $this->faker->text(),
            'in_abm' => $this->faker->boolean(),
            'supervision' => $this->faker->boolean(),
            'activation_lock' => $this->faker->boolean(),
            'lost_mode' => $this->faker->boolean(),
            'last_active_at' => $this->faker->dateTime(),
            'registered_at' => $this->faker->dateTime(),
        ];
    }
}
