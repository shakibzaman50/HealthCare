<?php

namespace Database\Factories;

use App\Enums\ScheduleEnums;
use App\Models\Medicine;
use App\Models\MedicineFrequency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicineFrequency>
 */
class MedicineFrequencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedicineFrequency::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'medicine_id' => Medicine::factory(),
            'end_date' => fake()->optional(0.7)->date(), // 70% chance of having end date
            'frequency_type' => fake()->randomElement(ScheduleEnums::cases()),
            'is_repeat' => fake()->boolean(60), // 60% chance of repeating
            'till_turn_off' => fake()->boolean(30), // 30% chance of being till turn off
        ];
    }
} 