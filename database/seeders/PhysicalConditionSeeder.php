<?php

namespace Database\Seeders;

use App\Models\PhysicalCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhysicalConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.physicalConditions') as $name){
            if(strlen($name) <= 40){
                PhysicalCondition::firstOrCreate(['name' => $name],[
                    'name'      => $name,
                    'is_active' => true,
                ]);
            }
        }
    }
}
