<?php

namespace Database\Factories;

use App\Enums\StatusEnums;
use App\Helpers\BSStatusCheck;
use App\Models\BsRecord;
use App\Models\Profile;
use App\Models\SugarSchedule;
use App\Models\SugarUnit;
use App\Models\UserProfile;
use Arr;
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
            'sugar_schedule_id' => 1,
            'sugar_unit_id' => 1,
            'value' => $this->faker->randomFloat(2, 60, 200),
            'status' => BsStatusCheck::getBsStatus($this->faker->randomFloat(2, 60, 200), $this->faker->randomElement(['Fasting', 'After Eating', '2Hr After Eating']), $this->faker->randomElement(['mg/dL', 'mmol/L'])),
            'measurement_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}