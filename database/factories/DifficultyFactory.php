<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Difficulty>
 */
class DifficultyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $difficulties = [
            'Facile' => '#008000',
            'Intermédiaire' => '#FFA500',
            'Difficile' => '#FF0000',
        ];

        $level = $this->faker->unique()->randomElement(array_keys($difficulties));

        return [
            'level' => $level,
            'color' => $difficulties[$level],
        ];
    }
}
