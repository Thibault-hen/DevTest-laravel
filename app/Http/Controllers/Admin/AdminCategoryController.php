<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Category\CreateOrUpdateCategoryData;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminCategoryController extends Controller
{
    public function index(CategoryService $categoryService): Response
    {
        $categories = $categoryService->getAllCategories();

        return Inertia::render('admin/Categories', [
            'categories' => $categories,
        ]);
    }

    public function store(CreateOrUpdateCategoryData $data, CategoryService $categoryService): RedirectResponse
    {
        $categoryService->createCategory($data);

        return to_route('admin.categories');
    }

    public function update(Category $category, Request $request, CategoryService $categoryService): RedirectResponse
    {
        $data = CreateOrUpdateCategoryData::validateAndCreate([
            ...$request->all(),
            'id' => $category->id,
        ]);

        $categoryService->updateCategory($category, $data);

        return to_route('admin.categories');
    }

    public function destroy(Category $category, CategoryService $categoryService): RedirectResponse
    {
        $categoryService->deleteCategory($category);

        return to_route('admin.categories');
    }
}
