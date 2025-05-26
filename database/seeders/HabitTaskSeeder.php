<?php

namespace Database\Seeders;

use App\Models\HabitList;
use App\Models\HabitTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HabitTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('basic.habitTasks') as $key => $items){
            if(strlen($key) <= 50){
                $list = HabitList::firstOrCreate(['name' => $key]);
                foreach ($items as $name){
                    if(strlen($name) <= 50){
                        HabitTask::firstOrCreate([
                            'habit_list_id' => $list->id,
                            'name'          => $name,
                        ]);
                    }
                }
            }
        }
    }
}
