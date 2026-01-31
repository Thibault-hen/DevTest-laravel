<?php

declare(strict_types=1);

namespace App\Services\Result;

class QuizScore
{
    private const int MILLISECONDS_PER_SECOND = 1000;

    private const int TIME_PENALTY_SECONDS = 5;

    private const int MULTIPLIER = 100;

    private const int POINTS_PER_CORRECT_ANSWER = 10;

    public function __construct(
        public readonly int $baseScore,
        public readonly int $timePenalty,
        public readonly int $finalScore) {}

    /**
     * Calculate the score based on correct answers and elapsed time with time penalty.
     *
     * @param  int  $correctAnswersCount  The number of correct answers
     * @param  int  $elapsedTime  The time taken to complete the quiz
     */
    public static function calculateScore(int $correctAnswersCount, int $elapsedTime): self
    {
        $baseScore = $correctAnswersCount * self::POINTS_PER_CORRECT_ANSWER * self::MULTIPLIER;

        // convert from ms to s
        $elapsedSeconds = $elapsedTime / self::MILLISECONDS_PER_SECOND;

        // add a timepenalty for each 5s
        $timePenalty = (int) ($elapsedSeconds / self::TIME_PENALTY_SECONDS) * self::MULTIPLIER;

        $finalScore = (int) max($baseScore - $timePenalty, 0);

        return new self($baseScore, $timePenalty, $finalScore);
    }
}
