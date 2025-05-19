<?php

namespace Database\Seeders;

use App\Models\BsMeasurementType;
use App\Models\BsRange;
use App\Models\SugarUnit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BsRangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the measurement types
        $fasting = BsMeasurementType::where('name', 'Fasting Blood Sugar')->first();
        $postMeal = BsMeasurementType::where('name', 'Post Meal')->first();
        $random = BsMeasurementType::where('name', 'Random Blood Sugar')->first();
        $hba1c = BsMeasurementType::where('name', 'HbA1c')->first();

        // Get the units
        $mgdL = SugarUnit::where('name', 'mg/dL')->first();
        $mmolL = SugarUnit::where('name', 'mmol/L')->first();

        $ranges = [
            // Fasting Blood Sugar ranges in mg/dL
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $fasting->id,
                'category' => 'Low',
                'min_value' => 0,
                'max_value' => 70,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $fasting->id,
                'category' => 'Normal',
                'min_value' => 70,
                'max_value' => 100,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $fasting->id,
                'category' => 'Pre-diabetic',
                'min_value' => 100,
                'max_value' => 126,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $fasting->id,
                'category' => 'Diabetic',
                'min_value' => 126,
                'max_value' => 500,
            ],

            // Post Meal ranges in mg/dL
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $postMeal->id,
                'category' => 'Normal',
                'min_value' => 0,
                'max_value' => 140,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $postMeal->id,
                'category' => 'Pre-diabetic',
                'min_value' => 140,
                'max_value' => 200,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $postMeal->id,
                'category' => 'Diabetic',
                'min_value' => 200,
                'max_value' => 500,
            ],

            // HbA1c ranges in percentage
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mmolL->id,
                'measurement_type_id' => $hba1c->id,
                'category' => 'Normal',
                'min_value' => 0,
                'max_value' => 5.7,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $hba1c->id,
                'category' => 'Pre-diabetic',
                'min_value' => 5.7,
                'max_value' => 6.5,
            ],
            [
                'id' => Str::uuid()->toString(),
                'sugar_unit_id' => $mgdL->id,
                'measurement_type_id' => $hba1c->id,
                'category' => 'Diabetic',
                'min_value' => 6.5,
                'max_value' => 15,
            ],
        ];

        foreach ($ranges as $range) {
            BsRange::create($range);
        }
    }
}