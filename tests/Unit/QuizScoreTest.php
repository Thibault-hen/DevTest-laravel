<?php

declare(strict_types=1);

use App\Services\Result\QuizScore;

it('should returns zero score when no correct answers', function () {
    $score = QuizScore::calculateScore(0, 60_000);

    expect($score->baseScore)->toBe(0)
        ->and($score->timePenalty)->toBe(0)
        ->and($score->finalScore)->toBe(0);
});

it('should computes base score as correctAnswers * 10 * 100', function () {
    $score = QuizScore::calculateScore(5, 1_000);

    expect($score->baseScore)->toBe(5_000);
});

it('should applies a time penalty based on average time per correct answer', function () {
    // 4 correct in 20s-> avg 5s/answer -> penalty = (5/5)*100 = 100
    $score = QuizScore::calculateScore(4, 20_000);

    expect($score->timePenalty)->toBe(100)
        ->and($score->finalScore)->toBe(4_000 - 100);
});

it('should caps the time penalty below the value of one correct answer', function () {
    // 1 correct in 600s -> avg 600s -> rawPenalty = (600/5)*100 = 12000
    // Max penalty = 10*100 - 1 = 999
    $score = QuizScore::calculateScore(1, 600_000);

    expect($score->timePenalty)->toBe(999)
        ->and($score->finalScore)->toBe(1_000 - 999);
});

it('should ensures more correct answers always results in a higher score', function (int $fewerCorrect, int $fewerTimeMs, int $moreCorrect, int $moreTimeMs) {
    $lower = QuizScore::calculateScore($fewerCorrect, $fewerTimeMs);
    $higher = QuizScore::calculateScore($moreCorrect, $moreTimeMs);

    expect($higher->finalScore)->toBeGreaterThan($lower->finalScore);
})->with([
    'user scenario: 8 correct 4min vs 12 correct 9min' => [8, 240_000, 12, 540_000],
    'edge: 1 correct instant vs 2 correct very slow' => [1, 1_000, 2, 999_000],
    'close: 5 correct 30s vs 6 correct 120s' => [5, 30_000, 6, 120_000],
]);

it('should rewards faster completion when correct answers are equal', function () {
    $fast = QuizScore::calculateScore(10, 30_000);
    $slow = QuizScore::calculateScore(10, 120_000);

    expect($fast->finalScore)->toBeGreaterThan($slow->finalScore)
        ->and($fast->baseScore)->toBe($slow->baseScore);
});

it('should never returns a negative final score', function () {
    $score = QuizScore::calculateScore(1, 9_999_000);

    expect($score->finalScore)->toBeGreaterThanOrEqual(0);
});
