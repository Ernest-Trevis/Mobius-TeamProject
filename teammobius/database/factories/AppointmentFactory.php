<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Patient;
use App\Models\User;

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
            'patient_id' => Patient::factory(),
            'doctor_id' => User::factory()->doctor(),
            'scheduled_at' => $start,
            'reason' => $this->faker->sentence(4),
            'notes' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['confirmed','completed','pending'])
        ];
    }
}
