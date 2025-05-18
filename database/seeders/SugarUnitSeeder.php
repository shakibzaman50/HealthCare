<?php

namespace Database\Seeders;

use App\Models\SugarUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SugarUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.sugarUnits') as $name){
            if(strlen($name) <= 20){
                SugarUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
