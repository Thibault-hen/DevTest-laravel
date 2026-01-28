<?php

declare(strict_types=1);

namespace App\Services\Category;

use App\Data\Category\CategoryData;
use App\Data\Category\CreateOrUpdateCategoryData;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function getAllCategories(): Collection
    {
        $categories = Category::all();
        $categories->loadCount('quizzes');

        return CategoryData::collect($categories);
    }

    public function createCategory(CreateOrUpdateCategoryData $data): CategoryData
    {
        $category = Category::create($data->toArray());

        return CategoryData::from($category);
    }

    public function updateCategory(Category $category, CreateOrUpdateCategoryData $data): CategoryData
    {
        $category->title = $data->title;
        $category->save();

        return CategoryData::from($category->refresh());
    }

    public function deleteCategory(Category $category): CategoryData
    {
        $categoryData = CategoryData::from($category);
        $category->delete();

        return $categoryData;
    }
}
