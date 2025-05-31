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
        foreach (config('basic.waterUnits') as $name => $value){
            if(strlen($name) <= 20){
                WaterUnit::updateOrCreate([
                    'name'       => $name,
                ], [
                    'name'       => $name,
                    'divided_by' => $value,
                ]);
            }
        }
    }
}
