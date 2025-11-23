<?php

namespace Database\Seeders;
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // $doctors = User::factory(5)->create(['role' => 'doctor']);
        // $patients = User::factory(5)->create(['role' => 'patient']);

        // $patients->each(function (User $user) use ($doctors){
        //     $patient = Patient::factory()->create([
        //         'user_id' => $user->id(),
        //         'first_name' => explode(' ',$user->name)[0],
        //         'last_name' => explode(' ',user->name)[1] ?? 'Patel'
        //     ]);

        //     Appointment::factory(rand(1,3))->create([
        //         'patient_id' => $patient->id,
        //         'user_id' => $doctors->random()->id(),
        //     ])->each(function (MedicalRecord $record){
        //         if(rand(0,1) === 1){
        //             Prescription::factory(rand(1,2))->create([
        //                 'medical_record_id' => $record->id
        //             ]);
        //         }
        //     });
        // });
        $this->call([
            PatientSeeder::class,
            MedicalRecordSeeder::class,
            PrescriptionSeeder::class,
            AppointmentSeeder::class
        ])
    }
}