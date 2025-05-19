<?php

namespace Database\Seeders;

use App\Models\BsMeasurementType;
use Illuminate\Database\Seeder;

class BsMeasurementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Fasting Blood Sugar',
            'Post Meal',
            'Random Blood Sugar',
            'HbA1c',
        ];

        foreach ($types as $type) {
            BsMeasurementType::create(['name' => $type]);
        }
    }
}