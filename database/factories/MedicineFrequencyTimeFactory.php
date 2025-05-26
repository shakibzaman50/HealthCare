<?php

namespace Database\Factories;

use App\Models\MedicineFrequency;
use App\Models\MedicineFrequencyTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicineFrequencyTime>
 */
class MedicineFrequencyTimeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MedicineFrequencyTime::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Common medicine taking times
        $commonTimes = [
            '08:00', // Morning
            '13:00', // Afternoon
            '20:00', // Evening
            '22:00', // Before bed
        ];

        return [
            'frequency_id' => MedicineFrequency::factory(),
            'time' => fake()->randomElement($commonTimes),
        ];
    }
} 