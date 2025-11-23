<?php

namespace Database\Seeders;

use App\Models\MedicalRecord;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // The factory now handles selecting a random patient and deriving the corresponding user_id.
        // This removes the need for manual patient ID lookups in the seeder.
        MedicalRecord::factory(100)->create();
        
        // Output a message for confirmation
        echo "Created 100 Medical Record records and assigned to patients and users.\n";
    }
}