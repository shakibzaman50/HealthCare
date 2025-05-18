<?php

namespace Database\Seeders;

use App\Models\MedicineUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.medicineUnits') as $name){
            if(strlen($name) <= 20){
                MedicineUnit::firstOrCreate(['name' => $name]);
            }
        }
    }
}
