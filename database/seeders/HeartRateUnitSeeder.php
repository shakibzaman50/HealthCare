<?php

namespace Database\Seeders;

use App\Models\HeartRateUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeartRateUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.heartRateUnits') as $name){
            if(strlen($name) <= 10){
                HeartRateUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
