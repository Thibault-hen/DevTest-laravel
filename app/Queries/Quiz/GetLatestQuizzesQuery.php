<?php

declare(strict_types=1);

namespace App\Queries\Quiz;

use App\Models\Quiz;
use Illuminate\Support\Collection;

final class GetLatestQuizzesQuery
{
    private const int DEFAULT_LIMIT = 3;

    public function execute(): Collection
    {
        return Quiz::with(['difficulty', 'author', 'category', 'themes'])
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->take(self::DEFAULT_LIMIT)
            ->get();
    }
}
