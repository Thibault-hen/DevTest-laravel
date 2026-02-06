<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Result;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Result>
 */
class ResultFactory extends Factory
{
    protected $model = Result::class;

    public function definition(): array
    {
        return [
            'completed_in' => $this->faker->numberBetween(30, 600),
            'score' => $this->faker->randomFloat(2, 0, 100),
            'user_id' => User::factory(),
            'quiz_id' => Quiz::factory(),
            'correct_answers_count' => $this->faker->numberBetween(0, 10),
        ];
    }
}
