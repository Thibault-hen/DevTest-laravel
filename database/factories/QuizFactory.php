<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Difficulty;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    protected $model = Quiz::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'description' => $this->faker->paragraph(),
            'duration' => $this->faker->numberBetween(5, 60),
            'image_url' => null,
            'is_published' => true,
            'author_id' => User::factory(),
            'difficulty_id' => Difficulty::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
