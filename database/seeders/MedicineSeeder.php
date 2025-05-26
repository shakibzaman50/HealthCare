<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineFrequency;
use App\Models\MedicineFrequencyTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 medicines with frequencies and times
        Medicine::factory()
            ->count(10)
            ->has(
                MedicineFrequency::factory()
                    ->count(2) // Each medicine has 2 frequencies
                    ->has(
                        MedicineFrequencyTime::factory()
                            ->count(3), // Each frequency has 3 times
                        'times'
                    ),
                'frequencies'
            )
            ->create();
    }
}
