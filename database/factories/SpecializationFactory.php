<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SpecializationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jobTitles = [
            'Développeur Web',
            'Développeur Mobile',
            'Chef de produit',
            'Graphiste',
            'Développeur back-end',
            'Développeur front-end',
            'Ingénieur DevOps',
        ];

        return [
            'name' => $this->faker->unique()->randomElement($jobTitles),
        ];
    }
}
