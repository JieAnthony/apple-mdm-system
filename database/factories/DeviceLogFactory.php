<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Random\Randomizer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceLog>
 */
class DeviceLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state' => new Randomizer()->getInt(0, 2),
            'content' => $this->faker->text(),
            'command_uuid' => $this->faker->uuid(),
            'response_at' => $this->faker->dateTime(),
        ];
    }
}
