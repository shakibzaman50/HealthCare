<?php

namespace Database\Seeders;

use App\Models\SugarSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SugarScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.sugarSchedules') as $name){
            if(strlen($name) <= 20){
                SugarSchedule::firstOrCreate(['name' => $name]);
            }
        }
    }
}
