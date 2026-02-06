<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence() . '?',
            'is_multiple' => false,
            'quiz_id' => Quiz::factory(),
        ];
    }
}
