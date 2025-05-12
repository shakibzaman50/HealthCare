<?php

namespace Database\Seeders;

use App\Models\WaterUnit;
use App\Models\WeightUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WeightUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.weightUnits') as $name){
            if(strlen($name) <= 10){
                WeightUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
