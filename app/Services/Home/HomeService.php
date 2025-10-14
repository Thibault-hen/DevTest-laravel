<?php

declare(strict_types=1);

namespace App\Services\Home;

use App\Data\Home\HomeData;
use App\Data\Quiz\QuizData;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;

class HomeService
{
    private const CACHE_KEY = 'homepage';

    private const CACHE_TTL = 3600;

    private const QUIZZES_COUNT = 3;

    public function getHomeData(): HomeData
    {
        return Cache::tags(['quiz'])
            ->remember(
                self::CACHE_KEY,
                self::CACHE_TTL,
                fn () => $this->buildHomeData()
            );
    }

    private function buildHomeData(): HomeData
    {
        $quizzes = $this->getLatestQuizzes();

        return new HomeData(
            quizzes: QuizData::collect($quizzes, DataCollection::class),
            quizCount: Quiz::count(),
            quizCompletedCount: Result::count(),
            themeCount: Theme::count(),
        );
    }

    private function getLatestQuizzes(): Collection
    {
        return Quiz::with(['difficulty', 'author', 'category', 'themes'])
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->take(self::QUIZZES_COUNT)
            ->get();
    }
}
