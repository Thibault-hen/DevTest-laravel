<?php

declare(strict_types=1);

namespace App\Queries\Home;

use App\Models\Quiz;
use App\Models\Result;
use App\Models\Theme;

final class GetHomeStatsQuery
{
    public function execute(): array
    {
        return [
            'quizCount' => Quiz::count(),
            'quizCompletedCount' => Result::count(),
            'themeCount' => Theme::count(),
        ];
    }
}
