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
     * The penalty is computed from average time per correct answer (not total time),
     * ensuring that answering more questions correctly — which naturally takes longer —
     * is never penalised more than the value it provides.
     * The penalty is capped so it can never outweigh the value of one additional correct answer.
     *
     * @param  int  $correctAnswersCount  The number of correct answers
     * @param  int  $elapsedTime  The time taken to complete the quiz in milliseconds
     */
    public static function calculateScore(int $correctAnswersCount, int $elapsedTime): self
    {
        $baseScore = $correctAnswersCount * self::POINTS_PER_CORRECT_ANSWER * self::MULTIPLIER;

        if ($correctAnswersCount === 0) {
            return new self(0, 0, 0);
        }

        $elapsedSeconds = $elapsedTime / self::MILLISECONDS_PER_SECOND;

        // Use average time per correct answer so more questions ≠ higher penalty
        $averageSecondsPerAnswer = $elapsedSeconds / $correctAnswersCount;

        $rawPenalty = (int) (($averageSecondsPerAnswer / self::TIME_PENALTY_SECONDS) * self::MULTIPLIER);

        // Cap so the penalty can never bridge the gap to the next correct-answer tier
        $maxPenalty = self::POINTS_PER_CORRECT_ANSWER * self::MULTIPLIER - 1;
        $timePenalty = min($rawPenalty, $maxPenalty);

        $finalScore = max($baseScore - $timePenalty, 0);

        return new self($baseScore, $timePenalty, $finalScore);
    }
}
