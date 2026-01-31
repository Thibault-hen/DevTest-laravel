<?php

declare(strict_types=1);

namespace App\Queries\Result;

use App\Models\Answer;
use Illuminate\Support\Collection;

final class GetCorrectAnswersByQuestionQuery
{
    public function execute(array $questionIds): Collection
    {
        return Answer::query()
            ->whereIn('question_id', $questionIds)
            ->where('is_correct', true)
            ->get()
            ->groupBy('question_id')
            ->map(fn ($answers) => $answers->pluck('id')->toArray());
    }
}
