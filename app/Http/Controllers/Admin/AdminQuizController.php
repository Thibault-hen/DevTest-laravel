<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Data\Quiz\admin\PublishQuizData;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\Quiz\QuizService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminQuizController extends Controller
{
    public function __construct(private readonly QuizService $quizService) {}

    public function index(): Response
    {
        $quizzesData = $this->quizService->getQuizzesData(true);

        return Inertia::render('admin/Quizzes', $quizzesData);
    }

    public function store(CreateOrUpdateQuizData $data): RedirectResponse
    {
        $this->quizService->createQuiz($data);

        return to_route('admin.quizzes');
    }

    public function update(Quiz $quiz, Request $request): RedirectResponse
    {
        $data = CreateOrUpdateQuizData::validateAndCreate([
            ...$request->all(),
            'id' => $quiz->id,
        ]);

        $this->quizService->updateQuiz($quiz, $data);

        return to_route('admin.quizzes');
    }

    public function destroy(Quiz $quiz): RedirectResponse
    {
        $this->quizService->deleteQuiz($quiz);

        return to_route('admin.quizzes');
    }

    public function setPublished(Quiz $quiz, PublishQuizData $data): RedirectResponse
    {
        $this->quizService->setQuizPublicationStatus($quiz, $data);

        return to_route('admin.quizzes');
    }
}
