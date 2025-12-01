<?php

declare(strict_types=1);

namespace App\Services\Rating;

use App\Data\Rating\RatingPostData;
use App\Models\Rating;

class RatingService
{
    public function hasUserRatedQuiz(string $userId, string $quizId): bool
    {
        return Rating::query()
            ->where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->exists();
    }

    public function createRating(RatingPostData $data): Rating
    {
        return Rating::create([
            ...$data->toArray(),
            'user_id' => auth()->id(),
        ]);
    }
}
