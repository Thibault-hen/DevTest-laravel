<?php

declare(strict_types=1);

namespace App\Observers\Quiz;

use App\Enums\CacheTags;
use App\Models\Quiz;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class QuizObserver
{
    public function saving(Quiz $quiz): void
    {
        if (empty($quiz->slug)) {
            $quiz->slug = Str::slug($quiz->title);
        }
    }

    public function saved(Quiz $quiz): void
    {
        $this->clearCache();
    }

    public function deleted(Quiz $quiz): void
    {
        $this->clearCache();
    }

    private function clearCache(): void
    {
        Cache::tags([CacheTags::QUIZ->value])->flush();
    }
}
