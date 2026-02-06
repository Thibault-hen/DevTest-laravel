<?php

declare(strict_types=1);

namespace App\Services\Rating;

use App\Data\Rating\RatingPostData;
use App\Models\Rating;
use App\Queries\Rating\HasUserRatedQuizQuery;

class RatingService
{
    public function __construct(private readonly HasUserRatedQuizQuery $hasUserRatedQuizQuery) {}

    public function hasUserRatedQuiz(string $userId, string $quizId): bool
    {
        return $this->hasUserRatedQuizQuery->execute($userId, $quizId);
    }

    public function createRating(RatingPostData $data): Rating
    {
        return Rating::create([
            ...$data->toArray(),
            'user_id' => auth()->id(),
        ]);
    }
}
