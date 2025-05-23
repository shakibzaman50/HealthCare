<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'avatar' => $this->faker->imageUrl,
            'age' => $this->faker->numberBetween(18, 65),
            'weight' => $this->faker->randomFloat(2, 50, 100),
            'height' => $this->faker->numberBetween(150, 200),
            'dob' => $this->faker->date,
            'bmi' => function (array $attributes) {
                // Calculate BMI using weight (kg) / height (m)^2
                $heightInMeters = $attributes['height'] / 100;
                return round($attributes['weight'] / ($heightInMeters * $heightInMeters), 1);
            },
        ];
    }
}
