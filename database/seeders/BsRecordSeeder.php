<?php

namespace Database\Seeders;

use App\Models\BsRecord;
use App\Models\Profile;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class BsRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only generate records if there are user profiles
        $userProfiles = Profile::all();

        if ($userProfiles->count() > 0) {
            // Create 5 blood sugar records for each user profile
            $userProfiles->each(function ($profile) {
                BsRecord::factory()
                    ->count(5)
                    ->create([
                        'profile_id' => $profile->id
                    ]);
            });
        }
    }
}