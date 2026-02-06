<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Enums\CacheKey;
use App\Enums\CacheTag;
use Illuminate\Support\Facades\Cache;

final class QuizCacheManager
{
    public function clear(): void
    {
        Cache::tags([CacheTag::QUIZ->value])->flush();
    }

    public function clearSpecific(CacheKey $cacheKey): void
    {
        Cache::tags([CacheTag::QUIZ->value])->forget($cacheKey->value);
    }
}
