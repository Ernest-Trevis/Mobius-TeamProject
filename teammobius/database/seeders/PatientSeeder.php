<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User; // Import the User model
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get all User IDs that have been seeded.
        $userIds = User::pluck('id');

        // 2. Create one Patient record for each User, ensuring a 1:1 link.
        // This makes sure the patient's records are owned by a specific user.
        foreach ($userIds as $userId) {
            Patient::factory()->create([
                // This is the crucial step: assigning the User ID to the Patient
                'user_id' => $userId, 
            ]);
        }
        
        echo "Created " . $userIds->count() . " Patient records, each linked to a User.\n";
    }
}