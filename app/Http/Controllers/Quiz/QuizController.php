<?php

declare(strict_types=1);

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Services\Quiz\QuizService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuizController extends Controller
{
    public function index(Request $request, QuizService $quizService): Response
    {
        $quizzesData = $quizService->getQuizzesData();

        return Inertia::render('quiz/Quizzes', $quizzesData);
    }
}
