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
        $medicalRecord = \App\Models\MedicalRecord::inRandomOrder()->first();

        if(!$medicalRecord){
            $medicalRecord = \App\Models\MedicalRecord::factory()->create();
        }

        return [
            'medical_record_id' => $medicalRecord->id,
            'medication_name' => $this->faker->randomElement(['Amoxicillin','Ibruprofen','Lisinopril','Prednisone']),
            'dosage' => $this->faker->randomElement(['500mg','10mg',' 2 puffs','1 tablet']),
            'instructions' => $this->faker->sentence(6),
            'quantity' => $this->faker->numberBetween(10,60)
        ];
    }
}
