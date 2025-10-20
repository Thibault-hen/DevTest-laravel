<?php

declare(strict_types=1);

namespace App\Services\Quiz;

use App\Data\Category\CategoryData;
use App\Data\Difficulty\DifficultyData;
use App\Data\Quiz\QuizData;
use App\Data\Quiz\QuizzesData;
use App\Data\Theme\ThemeData;
use App\Enums\CacheKeys;
use App\Enums\CacheTags;
use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Quiz;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;

class QuizService
{
    private const CACHE_TTL = 3600;

    public function getQuizzesData(): QuizzesData
    {
        return Cache::tags([CacheTags::QUIZ->value])->remember(
            CacheKeys::QUIZZES->value,
            self::CACHE_TTL,
            fn () => $this->buildQuizzesData()
        );
    }

    private function buildQuizzesData(): QuizzesData
    {
        $quizzes = $this->getAllQuizzes();

        $themes = Theme::all();
        $themes->loadCount('quizzes');

        $categories = Category::all();
        $categories->loadCount('quizzes');

        $difficulties = Difficulty::all();
        $difficulties->loadCount('quizzes');

        return new QuizzesData(
            quizzes: QuizData::collect($quizzes, DataCollection::class),
            themes: ThemeData::collect($themes, DataCollection::class),
            categories: CategoryData::collect($categories, DataCollection::class),
            difficulties: DifficultyData::collect($difficulties, DataCollection::class),
        );
    }

    public function getAllQuizzes(): Collection
    {
        return Quiz::with('themes', 'category', 'author', 'difficulty')
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->get();
    }

    public function getLatestQuizzes(int $quizzesCount): Collection
    {
        return Quiz::with(['difficulty', 'author', 'category', 'themes'])
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->take($quizzesCount)
            ->get();
    }
}
