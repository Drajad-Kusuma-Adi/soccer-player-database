<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Players>
 */
class PlayersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'position' => fake()->word(),
            'name' => fake()->name(),
            'back_number' => fake()->numberBetween(1, 11),
            'createdBy' => fake()->numberBetween(1, 30),
            'modifiedBy' => fake()->numberBetween(1, 30)
        ];
    }
}
