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
    /**
     * Calculate the score and save user result with a transaction to ensure
     * its integrity for a completed quiz.
     *
     * @param  \App\Models\Quiz  $quiz  The quiz being completed
     * @param  \App\Data\Result\ResultPostData  $resultData  The result data to save
     * @param  string  $userId  The ID of the user completing the quiz
     */
    public function saveResult(Quiz $quiz, ResultPostData $resultData, string $userId): void
    {
        $correctAnswersCount = $this->getCorrectAnswersCount($resultData);

        $score = QuizScore::calculateScore($correctAnswersCount, $resultData->total_time);

        // wrapping result creation into a transaction to ensure its integrity
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
        $questions = $resultData->questions->toCollection();
        $questionIds = $questions->pluck('question_id')->toArray();

        $correctAnswersByQuestion = $this->getCorrectAnswersByQuestion($questionIds);

        return $questions->filter(function ($questionData) use ($correctAnswersByQuestion) {
            $questionId = $questionData->question_id;
            $userAnswers = $questionData->answers;

            // Skip if no answer provided (timeout)
            if (empty($userAnswers)) {
                return false;
            }

            // Normalize to array if single answer
            $userAnswers = is_array($userAnswers) ? $userAnswers : [$userAnswers];

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
