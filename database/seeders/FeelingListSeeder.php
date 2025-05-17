<?php

namespace Database\Seeders;

use App\Models\FeelingList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeelingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.feelingLists') as $name){
            if(strlen($name) <= 30){
                FeelingList::firstOrCreate(['name' => $name]);
            }
        }
    }
}
