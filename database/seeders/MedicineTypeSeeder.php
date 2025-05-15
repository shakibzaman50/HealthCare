<?php

namespace Database\Seeders;

use App\Models\MedicineType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.medicineTypes') as $name){
            if(strlen($name) <= 20){
                MedicineType::firstOrCreate(['name' => $name]);
            }
        }
    }
}
