<?php

declare(strict_types=1);

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Quiz\QuizController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes');

Route::get('dashboard', function () {
    return Inertia::render('admin/Dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
