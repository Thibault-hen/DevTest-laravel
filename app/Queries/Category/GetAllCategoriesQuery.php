<?php

declare(strict_types=1);

namespace App\Queries\Category;

use App\Models\Category;
use Illuminate\Support\Collection;

final class GetAllCategoriesQuery
{
    public function execute(): Collection
    {
        $categories = Category::withCount('quizzes')->get();

        return $categories;
    }
}
