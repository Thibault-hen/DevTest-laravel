<?php

declare(strict_types=1);

namespace App\Queries\Theme;

use App\Models\Theme;
use Illuminate\Support\Collection;

final class GetAllThemeQuery
{
    public function execute(): Collection
    {
        $themes = Theme::withCount('quizzes')->get();

        return $themes;
    }
}
