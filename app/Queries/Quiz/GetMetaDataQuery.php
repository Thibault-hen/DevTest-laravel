<?php

declare(strict_types=1);

namespace App\Queries\Quiz;

use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Theme;

final class GetMetaDataQuery
{
    public function execute(): array
    {
        $themes = Theme::withCount('quizzes')->get();
        $difficulties = Difficulty::withCount('quizzes')->get();
        $categories = Category::withCount('quizzes')->get();

        return [
            'themes' => $themes,
            'difficulties' => $difficulties,
            'categories' => $categories,
        ];
    }
}
