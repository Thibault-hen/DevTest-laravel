<?php

declare(strict_types=1);

namespace App\Observers;

use App\Services\Cache\QuizCacheManager;

class DifficultyObserver
{
    public function __construct(
        private readonly QuizCacheManager $cacheManager,
    ) {}

    public function saved(): void
    {
        $this->cacheManager->clear();
    }

    public function deleted(): void
    {
        $this->cacheManager->clear();
    }
}
