<?php

declare(strict_types=1);

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Quiz\QuizController;
use App\Http\Controllers\Rating\RatingController;
use App\Http\Controllers\Result\ResultController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('quizzes')->group(function () {
    Route::get('/', [QuizController::class, 'index'])->name('quizzes');

    Route::get('/{quiz:slug}', [QuizController::class, 'show'])
        ->where('slug', '[a-z0-9-]+')
        ->name('quiz');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/results/{result}', [ResultController::class, 'show'])
            ->name('result.show');

        Route::get('/{quiz:slug}/play', [QuizController::class, 'play'])
            ->where('slug', '[a-z0-9-]+')
            ->name('quiz.play');

        Route::post('/{quiz:slug}/result', [ResultController::class, 'store'])
            ->where('slug', '[a-z0-9-]+')
            ->name('result.save');

        Route::post('/rating', [RatingController::class, 'store'])
            ->name('rating.store');
    });
});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->name('admin.dashboard');
    Route::get('/quizzes', function () {
        return Inertia::render('admin/Quizzes');
    })->name('admin.quizzes');
    Route::get('/themes', function () {
        return Inertia::render('admin/Themes');
    })->name('admin.themes');
    Route::get('/themes', function () {
        return Inertia::render('admin/Themes');
    })->name('admin.categories');
    Route::get('/themes', function () {
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
})->middleware(['auth', 'verified', 'admin']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
