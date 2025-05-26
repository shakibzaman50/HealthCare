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
        BloodSugar::factory()
            ->count(5)
            ->create([
                'profile_id' => 1
            ]);
    }   
}
