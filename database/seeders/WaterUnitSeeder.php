<?php

namespace Database\Seeders;

use App\Models\WaterUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WaterUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.waterUnits') as $name){
            if(strlen($name) <= 20){
                WaterUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
