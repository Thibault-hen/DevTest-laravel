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
        dd($data);
        $quizService->createQuiz($data);

        return to_route('admin.quizzes');
    }

    public function update(string $quizId, Request $request, QuizService $quizService): RedirectResponse
    {
        $data = CreateOrUpdateQuizData::from([
            ...$request->all(),
            'id' => $quizId,
        ]);

        $quizService->updateQuiz($quizId, $data);

        return to_route('admin.quizzes');
    }

    public function destroy(string $quizId, QuizService $quizService): RedirectResponse
    {
        $quizService->deleteQuiz($quizId);

        return to_route('admin.quizzes');
    }

    public function setPublished(string $quizId, PublishQuizData $data, QuizService $quizService): RedirectResponse
    {
        $quizService->setQuizPublicationStatus($quizId, $data);

        return to_route('admin.quizzes');
    }
}
