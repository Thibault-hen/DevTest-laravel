<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Answer>
 */
class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition(): array
    {
        return [
            'content' => $this->faker->sentence(),
            'is_correct' => false,
            'question_id' => Question::factory(),
        ];
    }
}
