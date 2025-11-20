<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prescription>
 */
class PrescriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medication_name' => $this->faker->randomElement(['Amoxicillin','Ibruprofen','Lisinopril','Prednisone']),
            'dosage' => $this->faker->randomElement(['500mg','10mg',' 2 puffs','1 tablet']),
            'instructions' => $this->faker->sentence(6),
            'quantity' => $this->faker->numberBetween(10,60)
        ];
    }
}
