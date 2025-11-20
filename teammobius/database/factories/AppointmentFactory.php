<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('-1 month','+1 month');

        return [
            'scheduled_at' => $start,
            'reason' => $this->faker->sentence(4),
            'notes' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['confirmed','completed','pending'])
        ];
    }
}
