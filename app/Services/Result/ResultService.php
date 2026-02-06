<?php

declare(strict_types=1);

namespace App\Services\Result;

use App\Actions\Result\SaveResultAction;
use App\Builders\QuizSummaryBuilder;
use App\Data\Result\ResultData;
use App\Data\Result\ResultPostData;
use App\Models\Quiz;
use App\Models\Result;
use Illuminate\Support\Collection;

class ResultService
{
    public function __construct(
        private readonly SaveResultAction $saveResultAction,
        private readonly QuizSummaryBuilder $quizSummaryBuilder,
    ) {}

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
        return $this->saveResultAction->handle($quiz, $resultData, $userId);
    }

    public function getAllQuizSummaryResults(): Collection
    {
        $results = Result::with('resultUserAnswers.answer.question', 'quiz.questions.answers', 'user')->get();

        $data = $results->map(function (Result $result) {
            $summaryData = $this->quizSummaryBuilder->build($result);

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

        $summaryData = $this->quizSummaryBuilder->build($result);

        return ResultData::from([
            ...$result->toArray(),
            'user_answers' => $summaryData['user_answers'],
            'results' => $summaryData['result'],
            'quiz' => $result->quiz,
            'user_rating' => $userRating,
        ]);
    }
}
