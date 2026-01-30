<?php

declare(strict_types=1);

namespace App\Services\Result;

use App\Data\Question\QuestionResultData;
use App\Data\Result\ResultData;
use App\Data\Result\ResultPostData;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ResultService
{
    public function __construct(private readonly AnswerChecker $answerChecker) {}

    /**
     * Calculate the score and save user result within a transaction to ensure
     * its integrity for a completed quiz.
     *
     * @param  \App\Models\Quiz  $quiz  The quiz being completed
     * @param  \App\Data\Result\ResultPostData  $resultData  The result data to save
     * @param  string  $userId  The ID of the user completing the quiz
     */
    public function saveResult(Quiz $quiz, ResultPostData $resultData, string $userId): Result
    {
        $correctAnswersCount = $this->answerChecker->getCorrectAnswersCount($resultData);

        $score = QuizScore::calculateScore($correctAnswersCount, $resultData->total_time);

        return DB::transaction(function () use ($quiz, $resultData, $score, $userId, $correctAnswersCount) {
            $result = $quiz->results()->create([
                'completed_in' => $resultData->total_time,
                'score' => $score->finalScore,
                'user_id' => $userId,
                'correct_answers_count' => $correctAnswersCount,
            ]);

            $result->resultUserAnswers()->createMany($this->formatUserAnswers($resultData));

            return $result;
        });
    }

    private function formatUserAnswers(ResultPostData $resultData): array
    {
        return $resultData->questions->toCollection()
            ->map(function ($answer) {
                if (empty($answer->answers)) {
                    return [
                        ['answer_id' => null],
                    ];
                }

                return collect((array) $answer->answers)
                    ->map(fn ($ans) => ['answer_id' => $ans])
                    ->toArray();
            })
            ->flatten(1)
            ->toArray();
    }

    public function getAllQuizSummaryResults(): Collection
    {
        $results = Result::with('resultUserAnswers.answer.question', 'quiz.questions.answers', 'user')->get();

        $data = $results->map(function ($result) {
            $summaryData = $this->buildQuizSummary($result);

            return ResultData::from([
                ...$result->toArray(),
                'user_answers' => $summaryData['user_answers'],
                'results' => $summaryData['result'],
                'quiz' => $result->quiz,
                'user' => $result->user,
            ]);
        });

        return $data;
    }

    public function getQuizSummaryResult(Result $result): ResultData
    {
        $result->load('resultUserAnswers.answer.question', 'quiz.questions.answers', 'quiz.ratings');

        $userRating = $result->quiz->ratings
            ->where('user_id', $result->user_id)
            ->first();

        $summaryData = $this->buildQuizSummary($result);

        return ResultData::from([
            ...$result->toArray(),
            'user_answers' => $summaryData['user_answers'],
            'results' => $summaryData['result'],
            'quiz' => $result->quiz,
            'user_rating' => $userRating,
        ]);
    }

    /**
     * get a complete summary of the quiz result including question details and correctness.
     *
     * @return array<string, mixed>
     */
    private function buildQuizSummary(Result $result): array
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
