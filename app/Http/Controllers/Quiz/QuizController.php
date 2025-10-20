<?php

declare(strict_types=1);

namespace App\Http\Controllers\Quiz;

use App\Data\Quiz\QuizData;
use App\Data\Quiz\QuizPlayData;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\Quiz\QuizService;
use Inertia\Inertia;
use Inertia\Response;

class QuizController extends Controller
{
    public function index(QuizService $quizService): Response
    {
        $quizzesData = $quizService->getQuizzesData();

        return Inertia::render('quiz/Quizzes', $quizzesData);
    }

    public function show(Quiz $quiz): Response
    {
        $quizDetails = $quiz->loadQuizDetails();

        return Inertia::render('quiz/Quiz', QuizData::from($quizDetails));
    }

    public function play(Quiz $quiz)
    {
        $quizDetails = $quiz->loadForPlaying();

        return Inertia::render('quiz/QuizPlay', QuizPlayData::from($quizDetails));
    }
}
