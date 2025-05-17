<?php

namespace Database\Seeders;

use App\Models\MedicineSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.medicineSchedules') as $name){
            if(strlen($name) <= 30){
                MedicineSchedule::firstOrCreate(['name' => $name]);
            }
        }
    }
}
