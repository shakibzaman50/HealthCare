<?php

namespace Database\Seeders;

use App\Models\ActivityLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivityLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.activityLevels') as $name){
            if(strlen($name) <= 30){
                ActivityLevel::firstOrCreate(['name' => $name]);
            }
        }
    }
}
