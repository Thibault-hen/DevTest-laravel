<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\AdminQuizController;
use App\Http\Controllers\Admin\AdminThemeController;
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

Route::get('/categories', function () {
    return Inertia::render('admin/Categories');
})->name('admin.categories');

Route::get('/difficulties', function () {
    return Inertia::render('admin/Difficulties');
})->name('admin.difficulties');

Route::get('/results', function () {
    return Inertia::render('admin/Results');
})->name('admin.results');

Route::get('/users', function () {
    return Inertia::render('admin/Users');
})->name('admin.users');
