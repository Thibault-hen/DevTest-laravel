<?php

declare(strict_types=1);

namespace App\Queries\Quiz;

use App\Models\Quiz;
use Illuminate\Support\Collection;

final class GetAllQuizzesQuery
{
    public function execute(bool $withQuestions): Collection
    {
        $quizzes = Quiz::with('themes', 'category', 'author', 'difficulty')
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->latest('title')
            ->get();

        if ($withQuestions) {
            $quizzes->load('questions.answers');
        }

        return $quizzes;
    }
}
