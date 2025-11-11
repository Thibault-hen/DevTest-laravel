<?php

declare(strict_types=1);

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Quiz\QuizController;
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
    });
});

Route::get('dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
