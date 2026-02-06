<?php

declare(strict_types=1);

namespace App\Actions\Result;

use App\Checkers\AnswerChecker;
use App\Data\Result\ResultPostData;
use App\Models\Quiz;
use App\Models\Result;
use App\Services\Result\QuizScore;
use DB;

final class SaveResultAction
{
    public function __construct(
        private readonly AnswerChecker $answerChecker,
        private readonly FormatUserAnswers $formatUserAnswers,
    ) {}

    public function handle(Quiz $quiz, ResultPostData $resultData, string $userId): Result
    {
        $correctAnswersCount = ($this->answerChecker)($resultData);

        $score = QuizScore::calculateScore($correctAnswersCount, $resultData->total_time);

        return DB::transaction(function () use ($quiz, $resultData, $score, $userId, $correctAnswersCount) {
            $result = $quiz->results()->create([
                'completed_in' => $resultData->total_time,
                'score' => $score->finalScore,
                'user_id' => $userId,
                'correct_answers_count' => $correctAnswersCount,
            ]);

            $result->resultUserAnswers()->createMany($this->formatUserAnswers->handle($resultData));

            return $result;
        });
    }
}
