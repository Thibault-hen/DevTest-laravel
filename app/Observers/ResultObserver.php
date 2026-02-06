<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\CacheKey;
use App\Services\Cache\QuizCacheManager;

class ResultObserver
{
    public function __construct(
        private readonly QuizCacheManager $cacheManager,
    ) {}

    public function saved(): void
    {
        $this->cacheManager->clearSpecific(CacheKey::HOME);
    }

    public function deleted(): void
    {
        $this->cacheManager->clearSpecific(CacheKey::HOME);
    }
}
