<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceInstalledApplication>
 */
class DeviceInstalledApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identifier' => $this->faker->uuid(),
            'name' => $this->faker->name,
            'version' => 'v'.$this->faker->randomNumber(),
        ];
    }
}
