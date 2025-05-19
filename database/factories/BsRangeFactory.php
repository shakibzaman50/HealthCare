<?php

namespace Database\Factories;

use App\Models\BsMeasurementType;
use App\Models\SugarUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BsRange>
 */
class BsRangeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $min = $this->faker->randomFloat(2, 60, 100);
        $max = $this->faker->randomFloat(2, $min + 10, $min + 50);

        return [
            'id' => $this->faker->uuid,
            'unit_id' => SugarUnit::factory(),
            'measurement_type_id' => BsMeasurementType::factory(),
            'category' => $this->faker->randomElement(['Low', 'Normal', 'High', 'Very High']),
            'min_value' => $min,
            'max_value' => $max,
        ];
    }
}