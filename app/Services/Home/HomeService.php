<?php

declare(strict_types=1);

namespace App\Services\Home;

use App\Data\Home\HomeData;
use App\Data\Quiz\QuizData;
use App\Enums\CacheKeys;
use App\Enums\CacheTags;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\Theme;
use App\Services\Quiz\QuizService;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;

class HomeService
{
    private const CACHE_TTL = 3600;

    private const QUIZZES_COUNT = 3;

    public function __construct(private readonly QuizService $quizService) {}

    public function getHomeData(): HomeData
    {
        return Cache::tags([CacheTags::QUIZ->value])
            ->remember(
                CacheKeys::HOME->value,
                self::CACHE_TTL,
                fn () => $this->buildHomeData()
            );
    }

    private function buildHomeData(): HomeData
    {
        $quizzes = $this->quizService->getLatestQuizzes(self::QUIZZES_COUNT);

        return new HomeData(
            quizzes: QuizData::collect($quizzes, DataCollection::class),
            quizCount: Quiz::count(),
            quizCompletedCount: Result::count(),
            themeCount: Theme::count(),
        );
    }
}
