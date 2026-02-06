<?php

declare(strict_types=1);

namespace App\Services\Home;

use App\Data\Home\HomeData;
use App\Data\Quiz\QuizData;
use App\Enums\CacheKey;
use App\Enums\CacheTag;
use App\Queries\Home\GetHomeStatsQuery;
use App\Queries\Quiz\GetLatestQuizzesQuery;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;

class HomeService
{
    private const int CACHE_TTL = 3600;

    public function __construct(
        private readonly GetHomeStatsQuery $getHomeStatsQuery,
        private readonly GetLatestQuizzesQuery $getLatestQuizzesQuery
    ) {}

    public function getHomeData(): HomeData
    {
        return Cache::tags([CacheTag::QUIZ->value])
            ->remember(
                CacheKey::HOME->value,
                self::CACHE_TTL,
                $this->buildHomeData(...)
            );
    }

    private function buildHomeData(): HomeData
    {
        $quizzes = $this->getLatestQuizzesQuery->execute();
        $stats = $this->getHomeStatsQuery->execute();

        return new HomeData(
            quizzes: QuizData::collect($quizzes, DataCollection::class),
            quizCount: $stats['quizCount'],
            quizCompletedCount: $stats['quizCompletedCount'],
            themeCount: $stats['themeCount'],
        );
    }
}
