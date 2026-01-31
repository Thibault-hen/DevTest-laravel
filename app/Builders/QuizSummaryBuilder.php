<?php

namespace App\Builders;

use App\Data\Question\QuestionResultData;
use App\Models\Result;

final class QuizSummaryBuilder
{
    public function build(Result $result): array
    {
        $allQuestions = $result->quiz->questions->keyBy('id');

        $answeredQuestions = collect($result->resultUserAnswers)
            ->filter(fn ($ua) => $ua->answer_id !== null)
            ->groupBy(fn ($ua) => $ua->answer->question->id);

        $questionsList = $allQuestions->map(function ($question) use ($answeredQuestions) {
            $userAnswers = $answeredQuestions->get($question->id);

            if (! $userAnswers) {
                return [
                    'question' => QuestionResultData::from($question),
                    'is_correct' => false,
                ];
            }

            $isCorrect = $question->is_multiple
                ? $userAnswers->every(fn ($ua) => $ua->answer->is_correct)
                : $userAnswers->first()->answer->is_correct;

            return [
                'question' => QuestionResultData::from($question),
                'is_correct' => $isCorrect,
            ];
        })->values()->toArray();

        $userAnswers = $result->resultUserAnswers
            ->pluck('answer')
            ->filter()
            ->values()
            ->toArray();

        return [
            'result' => $questionsList,
            'user_answers' => $userAnswers,
        ];
    }
}
