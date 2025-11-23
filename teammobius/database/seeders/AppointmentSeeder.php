<?php

namespace Database\Seeders;

use App\Models\Appointment; // Import the Appointment model
use App\Models\User; // Import the User model
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::factory(100)->create();
    }
}