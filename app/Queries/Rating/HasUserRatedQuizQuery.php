<?php

declare(strict_types=1);

namespace App\Queries\Rating;

use App\Models\Rating;

final class HasUserRatedQuizQuery
{
    public function execute(string $userId, string $quizId): bool
    {
        return Rating::query()
            ->where('user_id', $userId)
            ->where('quiz_id', $quizId)
            ->exists();
    }
}
