<?php

namespace Database\Factories;

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
            'user_id' => 1,
            'name' => fake()->name(),
            'avatar' => null,
            'age' => fake()->numberBetween(18, 80),
            'weight' => fake()->randomFloat(2, 40, 150),
            'height' => fake()->randomFloat(2, 140, 200),
            'dob' => fake()->date(),
            'bmi' => fake()->randomFloat(2, 15, 40),
        ];
    }
}
