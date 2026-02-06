<?php

declare(strict_types=1);

namespace App\Observers;

use App\Services\Cache\QuizCacheManager;

class RatingObserver
{
    public function __construct(private readonly QuizCacheManager $quizCacheManager) {}

    public function creating(): void
    {
        $this->quizCacheManager->clear();
    }
}
