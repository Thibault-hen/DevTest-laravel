<?php

declare(strict_types=1);

namespace App\Services\Result;

use App\Data\Result\ResultPostData;
use App\Models\Answer;
use App\Models\Quiz;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResultService
{
    public function saveResult(Quiz $quiz, ResultPostData $resultData, string $userId): void
    {
        $correctAnswersCount = $this->getCorrectAnswersCount($resultData);

        $score = QuizScore::calculateScore($correctAnswersCount, $resultData->total_time);

        DB::transaction(function () use ($quiz, $resultData, $score, $userId) {
            $result = $quiz->results()->create([
                'completed_in' => $resultData->total_time,
                'score' => $score->finalScore,
                'user_id' => $userId,
            ]);

            $result->resultUserAnswers()->createMany($this->formatUserAnswers($resultData));
        });
    }

    private function getCorrectAnswersByQuestion(array $questionIds): Collection
    {
        return Answer::query()
            ->whereIn('question_id', $questionIds)
            ->where('is_correct', true)
            ->get()
            ->groupBy('question_id')
            ->map(fn ($answers) => $answers->pluck('id')->toArray());
    }

    private function getCorrectAnswersCount(ResultPostData $resultData): int
    {
        // Get all question IDs - DataCollection already has items() method
        $questions = $resultData->questions->toCollection();
        $questionIds = $questions->pluck('question_id')->toArray();

        // Load ALL correct answers in ONE query, grouped by question
        $correctAnswersByQuestion = $this->getCorrectAnswersByQuestion($questionIds);

        // Check each question - use DataCollection directly
        return $questions->filter(function ($questionData) use ($correctAnswersByQuestion) {
            $questionId = $questionData->question_id;
            $userAnswers = $questionData->answers;

            // Skip if no answer provided (timeout)
            if (empty($userAnswers)) {
                return false;
            }

            // Normalize to array and sort
            $userAnswers = is_array($userAnswers) ? $userAnswers : [$userAnswers];

            // Get correct answers for this question and sort
            $correctAnswers = $correctAnswersByQuestion->get($questionId, []);

            sort($userAnswers);
            sort($correctAnswers);

            return $userAnswers === $correctAnswers;
        })
            ->count();
    }

    private function formatUserAnswers(ResultPostData $resultData): array
    {
        return $resultData->questions->toCollection()
            ->flatMap(fn ($question) => collect((array) $question->answers)
                ->filter(fn ($answer) => ! empty($answer))
                ->map(fn ($answer) => ['answer_id' => $answer]))
            ->toArray();
    }
}
