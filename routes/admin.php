<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminDifficultyController;
use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminResultController;
use App\Http\Controllers\Admin\AdminSpecializationController;
use App\Http\Controllers\Admin\AdminThemeController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->name('admin.dashboard');

Route::prefix('/quizzes')->group(function () {
    Route::get('/', [AdminQuizController::class, 'index'])
        ->name('admin.quizzes');
    Route::post('/', [AdminQuizController::class, 'store'])
        ->name('admin.quizzes.create');
    Route::put('/{quiz}', [AdminQuizController::class, 'update'])
        ->name('admin.quizzes.update');
    Route::put('/publish/{quiz}', [AdminQuizController::class, 'setPublished'])
        ->name('admin.quizzes.publish');
    Route::delete('/{quiz}', [AdminQuizController::class, 'destroy'])
        ->name('admin.quizzes.delete');
});

Route::prefix('/themes')->group(function () {
    Route::get('/', [AdminThemeController::class, 'index'])
        ->name('admin.themes');
    Route::post('/', [AdminThemeController::class, 'store'])
        ->name('admin.themes.create');
    Route::put('/{theme}', [AdminThemeController::class, 'update'])
        ->name('admin.themes.update');
    Route::delete('/{theme}', [AdminThemeController::class, 'destroy'])
        ->name('admin.themes.delete');
});

Route::prefix('/categories')->group(function () {
    Route::get('/', [AdminCategoryController::class, 'index'])
        ->name('admin.categories');
    Route::post('/', [AdminCategoryController::class, 'store'])
        ->name('admin.categories.create');
    Route::put('/{category}', [AdminCategoryController::class, 'update'])
        ->name('admin.categories.update');
    Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])
        ->name('admin.categories.delete');
});

Route::prefix('/difficulties')->group(function () {
    Route::get('/', [AdminDifficultyController::class, 'index'])
        ->name('admin.difficulties');
    Route::post('/', [AdminDifficultyController::class, 'store'])
        ->name('admin.difficulties.create');
    Route::put('/{difficulty}', [AdminDifficultyController::class, 'update'])
        ->name('admin.difficulties.update');
    Route::delete('/{difficulty}', [AdminDifficultyController::class, 'destroy'])
        ->name('admin.difficulties.delete');
});

Route::prefix('/results')->group(function () {
    Route::get('/', [AdminResultController::class, 'index'])
        ->name('admin.results');
    Route::delete('/{result}', [AdminResultController::class, 'destroy'])
        ->name('admin.results.delete');
});

Route::prefix('/users')->group(function () {
    Route::get('/', [AdminUserController::class, 'index'])
        ->name('admin.users');
    Route::delete('/{user}', [AdminUserController::class, 'destroy'])
        ->name('admin.users.delete');
});

Route::prefix('/specializations')->group(function () {
    Route::get('/', [AdminSpecializationController::class, 'index'])
        ->name('admin.specializations');
    Route::post('/', [AdminSpecializationController::class, 'store'])
        ->name('admin.specializations.create');
    Route::put('/{specialization}', [AdminSpecializationController::class, 'update'])
        ->name('admin.specializations.update');
    Route::delete('/{specialization}', [AdminSpecializationController::class, 'destroy'])
        ->name('admin.specializations.delete');
});
