<?php

namespace Database\Seeders;

use App\Models\HeightUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeightUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.heightUnits') as $name){
            if(strlen($name) <= 20){
                HeightUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
