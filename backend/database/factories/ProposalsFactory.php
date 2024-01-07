<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProposalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'accepted', 'declined']);

        return [
            'created_by' => fake()->numberBetween(1, 30),
            'processed_by' => $status == 'pending' ? null : fake()->numberBetween(1, 30),
            'name' => fake()->name(),
            'position' => fake()->word(),
            'description' => fake()->text(),
            'status' => $status,
        ];
    }
}
