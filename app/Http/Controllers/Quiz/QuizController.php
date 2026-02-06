<?php

declare(strict_types=1);

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\Quiz\QuizService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;
use Inertia\Response;

class QuizController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private readonly QuizService $quizService,
    ) {}

    public function index(): Response
    {
        $quizzesData = $this->quizService->getQuizzesData();

        return Inertia::render('quiz/Quizzes', $quizzesData);
    }

    public function show(Quiz $quiz): Response
    {
        $quizDetails = $this->quizService->getQuizDetails($quiz);

        return Inertia::render('quiz/Quiz', $quizDetails);
    }

    public function play(Quiz $quiz): Response
    {
        $this->authorize('play', $quiz);

        $quizDetails = $this->quizService->getQuizPlay($quiz);

        return Inertia::render('quiz/QuizPlay', $quizDetails);
    }
}
