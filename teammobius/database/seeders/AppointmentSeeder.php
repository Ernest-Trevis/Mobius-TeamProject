<?php

namespace Database\Seeders;

use App\Models\Appointments;
use App\Models\User; // Import the User model
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointments::factory(100)->create();
    }
}