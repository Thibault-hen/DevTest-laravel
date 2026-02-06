<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Result;
use App\Models\User;

class ResultPolicy
{
    public function view(User $user, Result $result): bool
    {
        return $user->id === $result->user_id;
    }

    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }
}
