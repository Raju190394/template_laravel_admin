<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->jobTitle() . ' Course',
            'description' => fake()->paragraph(),
            'duration' => fake()->numberBetween(1, 12) . ' Months',
            'price' => fake()->randomFloat(2, 50, 500),
        ];
    }
}
