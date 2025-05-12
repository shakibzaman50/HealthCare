<?php

namespace Database\Seeders;

use App\Models\BloodPressureUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BloodPressureUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.bloodPressureUnits') as $name){
            if(strlen($name) <= 10){
                BloodPressureUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
