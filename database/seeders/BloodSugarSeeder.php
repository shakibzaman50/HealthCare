<?php

namespace Database\Seeders;

use App\Models\BloodSugar;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodSugarSeeder extends Seeder
{
    public function run(): void
    {
        // Only generate records if there are user profiles
        $userProfiles = Profile::factory()->create();

        if ($userProfiles->count() > 0) {
            // Create 5 blood sugar records for each user profile
            $userProfiles->each(function ($profile) {
              BloodSugar::factory()
                  ->count(5)
                  ->create([
                      'profile_id' => $profile->id
                  ]);
              });
          }
    }   
}
