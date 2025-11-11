<?php

declare(strict_types=1);

namespace App\Services\Result;

use App\Data\Result\ResultPostData;
use App\Models\Answer;
use Illuminate\Support\Collection;

class AnswerChecker
{
    private function getCorrectAnswersByQuestion(array $questionIds): Collection
    {
        return Answer::query()
            ->whereIn('question_id', $questionIds)
            ->where('is_correct', true)
            ->get()
            ->groupBy('question_id')
            ->map(fn ($answers) => $answers->pluck('id')->toArray());
    }

    public function getCorrectAnswersCount(ResultPostData $resultData): int
    {
        $questions = $resultData->questions->toCollection();
        $questionIds = $questions->pluck('question_id')->toArray();

        $correctAnswersByQuestion = $this->getCorrectAnswersByQuestion($questionIds);

        return $questions->filter(fn ($questionData) => $this->isCorrect(
            $questionData->question_id,
            $questionData->answers ?? null,
            $correctAnswersByQuestion
        )
        )->count();
    }

    private function isCorrect(string $questionId, mixed $userAnswers, Collection $correctAnswersByQuestion): bool
    {
        // timeout or no answer given
        if (empty($userAnswers)) {
            return false;
        }

        // Normalize if single answer (no multiple choice)
        $userAnswers = is_array($userAnswers) ? $userAnswers : [$userAnswers];

        $correctAnswers = $correctAnswersByQuestion->get($questionId, []);

        sort($userAnswers);
        sort($correctAnswers);

        return $userAnswers === $correctAnswers;
    }
}
