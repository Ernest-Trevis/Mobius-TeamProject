<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MedicalRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'visit_date' => $this->faker->dateTimeBetween('-1 year','now'),
            'symptoms' => $this->faker->paragraph(2),
            'diagnosis' => $this->faker->randomElement(['Common Cold','Seasonal Flu','Minor Fracture','Hypertension']),
            'treatment' => $this->faker->paragraph(3)
        ];
    }
}
