<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    public function play(?User $user, Quiz $quiz): bool
    {
        if ($user?->is_admin) {
            return true;
        }

        return $quiz->is_published;
    }
}
