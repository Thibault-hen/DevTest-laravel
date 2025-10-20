<?php

declare(strict_types=1);

namespace App\Services\Result;

class QuizScore
{
    private const MILLISECONDS_PER_SECOND = 1000;

    private const TIME_PENALTY_SECONDS = 10;

    private const MULTIPLIER = 100;

    private const POINTS_PER_CORRECT_ANSWER = 10;

    public function __construct(
        public readonly int $baseScore,
        public readonly int $timePenalty,
        public readonly int $finalScore) {}

    public static function calculateScore(int $correctAnswersCount, int $elapsedTime): self
    {
        $baseScore = $correctAnswersCount * self::POINTS_PER_CORRECT_ANSWER * self::MULTIPLIER;

        // convert from ms to s
        $elapsedSeconds = $elapsedTime / self::MILLISECONDS_PER_SECOND;

        // add a timepenalty for each 10s
        $timePenalty = (int) ($elapsedSeconds / self::TIME_PENALTY_SECONDS * self::MULTIPLIER);

        $finalScore = (int) max($baseScore - $timePenalty, 0);

        return new self($baseScore, $timePenalty, $finalScore);
    }
}
