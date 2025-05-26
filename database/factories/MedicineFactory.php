<?php

namespace Database\Factories;

use App\Models\Medicine;
use App\Models\MedicineType;
use App\Models\MedicineUnit;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medicine>
 */
class MedicineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Medicine::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profile_id' => 1,
            'medicine_type_id' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9]),
            'medicine_unit_id' => fake()->randomElement([1, 2, 3, 4, 5]),
            'name' => fake()->randomElement([
                'Paracetamol',
                'Ibuprofen',
                'Aspirin',
                'Amoxicillin',
                'Metformin',
                'Omeprazole',
                'Lisinopril',
                'Simvastatin',
            ]),
            'strength' => fake()->randomElement([100, 200, 250, 500, 1000]),
            'is_active' => fake()->boolean(80), // 80% chance of being active
            'notes' => fake()->optional(0.7)->sentence(), // 70% chance of having notes
        ];
    }
} 