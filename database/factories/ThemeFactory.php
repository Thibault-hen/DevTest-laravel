<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Theme>
 */
class ThemeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $themes = [
            'PHP',
            'JavaScript',
            'Docker',
            'Kubernetes',
            'HTML',
            'CSS',
            'Git',
            'Node.js',
            'React',
            'SQL',
            'Python',
            'Linux',
            'Vue.js',
            'Angular',
        ];

        return [
            'title' => $this->faker->unique()->randomElement($themes),
        ];
    }
}
