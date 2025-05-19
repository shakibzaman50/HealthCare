<?php

namespace Database\Factories;

use App\Models\BsMeasurementType;
use App\Models\BsRecord;
use App\Models\Profile;
use App\Models\SugarUnit;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BsRecord>
 */
class BsRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => Profile::factory(),
            'measurement_type_id' => BsMeasurementType::factory(),
            'unit_id' => SugarUnit::factory(),
            'value' => $this->faker->randomFloat(2, 60, 200),
            'insert_date' => $this->faker->dateTimeThisYear(),
            'insert_time' => $this->faker->numberBetween(0, 86400), // Seconds in a day
        ];
    }
}