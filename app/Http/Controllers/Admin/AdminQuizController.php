<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Category\CategoryData;
use App\Data\Difficulty\DifficultyData;
use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Data\Quiz\admin\PublishQuizData;
use App\Data\Quiz\QuizData;
use App\Data\Theme\ThemeData;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Quiz;
use App\Models\Theme;
use App\Services\Quiz\QuizService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\LaravelData\DataCollection;

class AdminQuizController extends Controller
{
    public function index(QuizService $quizService): Response
    {
        $quizzes = $quizService->getAllQuizzes();
        $quizzes = $quizzes->load('questions.answers');

        $themes = Theme::all();
        $categories = Category::all();
        $diffulties = Difficulty::all();

        return Inertia::render('admin/Quizzes', [
            'quizzes' => QuizData::collect($quizzes, DataCollection::class),
            'themes' => ThemeData::collect($themes, DataCollection::class),
            'categories' => CategoryData::collect($categories, DataCollection::class),
            'difficulties' => DifficultyData::collect($diffulties, DataCollection::class),
        ]);
    }

    public function store(CreateOrUpdateQuizData $data, QuizService $quizService): RedirectResponse
    {
        $quizService->createQuiz($data);

        return to_route('admin.quizzes');
    }

    public function update(Quiz $quiz, Request $request, QuizService $quizService): RedirectResponse
    {
        $data = CreateOrUpdateQuizData::validateAndCreate([
            ...$request->all(),
            'id' => $quiz->id,
        ]);

        $quizService->updateQuiz($quiz, $data);

        return to_route('admin.quizzes');
    }

    public function destroy(Quiz $quiz, QuizService $quizService): RedirectResponse
    {
        $quizService->deleteQuiz($quiz);

        return to_route('admin.quizzes');
    }

    public function setPublished(Quiz $quiz, PublishQuizData $data, QuizService $quizService): RedirectResponse
    {
        $quizService->setQuizPublicationStatus($quiz, $data);

        return to_route('admin.quizzes');
    }
}
