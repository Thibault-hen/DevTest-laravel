<?php

declare(strict_types=1);

namespace App\Checkers;

use App\Data\Result\ResultPostData;
use App\Queries\Result\GetCorrectAnswersByQuestionQuery;
use Illuminate\Support\Collection;

final class AnswerChecker
{
    public function __construct(private readonly GetCorrectAnswersByQuestionQuery $getCorrectAnswersByQuestionQuery) {}

    /**
     * Get correct answers count from the user's result data.
     *
     * @param  \App\Data\Result\ResultPostData  $resultData  The result data containing user answers
     */
    public function __invoke(ResultPostData $resultData): int
    {
        $questions = $resultData->questions->toCollection();
        $questionIds = $questions->pluck('question_id')->toArray();

        $correctAnswersByQuestion = $this->getCorrectAnswersByQuestionQuery->execute($questionIds);

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

        // Normalize if single answer (no multiple choices)
        $userAnswers = is_array($userAnswers) ? $userAnswers : [$userAnswers];

        $correctAnswers = $correctAnswersByQuestion->get($questionId, []);

        sort($userAnswers);
        sort($correctAnswers);

        return $userAnswers === $correctAnswers;
    }
}
