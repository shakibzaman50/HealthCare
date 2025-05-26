<?php

namespace Database\Factories;

use App\Helpers\BloodSugarStatus;
use App\Models\SugarSchedule;
use App\Models\SugarUnit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BloodSugar>
 */
class BloodSugarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $value = fake()->randomFloat(2, 70, 200);

        $schedule = SugarSchedule::whereIn('id', [1, 2, 3])->inRandomOrder()->first();
        $unit = SugarUnit::whereIn('id', [1])->inRandomOrder()->first();

        return [
            'profile_id' => 1,
            'sugar_schedule_id' => $schedule->id,
            'sugar_unit_id' => $unit->id,
            'value' => $value,
            'measured_at' => now()->subDays(fake()->numberBetween(1, 7)),
        ];
    }
}
