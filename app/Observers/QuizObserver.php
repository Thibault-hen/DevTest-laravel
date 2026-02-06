<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Quiz;
use App\Services\Cache\QuizCacheManager;
use Illuminate\Support\Str;

class QuizObserver
{
    public function __construct(
        private readonly QuizCacheManager $cacheManager,
    ) {}

    public function saving(Quiz $quiz): void
    {
        if (empty($quiz->slug)) {
            $quiz->slug = Str::slug($quiz->title);
        }
    }

    public function saved(): void
    {
        $this->cacheManager->clear();
    }

    public function deleted(): void
    {
        $this->cacheManager->clear();
    }
}
