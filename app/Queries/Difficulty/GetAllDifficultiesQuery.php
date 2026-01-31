<?php

declare(strict_types=1);

namespace App\Queries\Difficulty;

use App\Models\Difficulty;
use Illuminate\Support\Collection;

final class GetAllDifficultiesQuery
{
    public function execute(): Collection
    {
        $difficulties = Difficulty::with('quizzes')->get();

        return $difficulties;
    }
}
