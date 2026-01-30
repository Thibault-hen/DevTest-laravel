<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\ResultUserAnswer;
use App\Models\Result;
use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResultUserAnswer>
 */
class ResultUserAnswerFactory extends Factory
{
    protected $model = ResultUserAnswer::class;

    public function definition(): array
    {
        return [
            'result_id' => Result::factory(),
            'answer_id' => Answer::factory(),
        ];
    }
}
