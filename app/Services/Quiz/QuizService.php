<?php

declare(strict_types=1);

namespace App\Services\Quiz;

use App\Data\Category\CategoryData;
use App\Data\Difficulty\DifficultyData;
use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Data\Quiz\admin\PublishQuizData;
use App\Data\Quiz\QuizData;
use App\Data\Quiz\QuizzesData;
use App\Data\Theme\ThemeData;
use App\Enums\CacheKeys;
use App\Enums\CacheTags;
use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Quiz;
use App\Models\Theme;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\LaravelData\DataCollection;

class QuizService
{
    private const CACHE_TTL = 3600;

    public function getQuizzesData(): QuizzesData
    {
        return Cache::tags([CacheTags::QUIZ->value])->remember(
            CacheKeys::QUIZZES->value,
            self::CACHE_TTL,
            fn () => $this->buildQuizzesData()
        );
    }

    private function buildQuizzesData(): QuizzesData
    {
        $quizzes = $this->getAllQuizzes();

        $themes = Theme::all();
        $themes->loadCount('quizzes');

        $categories = Category::all();
        $categories->loadCount('quizzes');

        $difficulties = Difficulty::all();
        $difficulties->loadCount('quizzes');

        return new QuizzesData(
            quizzes: QuizData::collect($quizzes, DataCollection::class),
            themes: ThemeData::collect($themes, DataCollection::class),
            categories: CategoryData::collect($categories, DataCollection::class),
            difficulties: DifficultyData::collect($difficulties, DataCollection::class),
        );
    }

    public function getAllQuizzes(): Collection
    {
        return Quiz::with('themes', 'category', 'author', 'difficulty')
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->get();
    }

    public function getLatestQuizzes(int $quizzesCount): Collection
    {
        return Quiz::with(['difficulty', 'author', 'category', 'themes'])
            ->withAvg('ratings', 'score')
            ->withCount('ratings')
            ->latest('created_at')
            ->take($quizzesCount)
            ->get();
    }

    private function storeQuizImage(?UploadedFile $icon, ?string $title): ?string
    {
        if (! $icon) {
            return null;
        }

        $fileName = Str::slug(($title ?? 'quiz-icon').'-'.time()).'.'.$icon->guessExtension();
        $path = $icon->storeAs('icons', $fileName, 'public');

        return Storage::url($path);
    }

    private function createQuestions(CreateOrUpdateQuizData $data, Quiz $quiz): void
    {
        foreach ($data->questions as $questionData) {
            $question = $quiz->questions()->create([
                'content' => $questionData->content,
                'is_multiple' => $questionData->is_multiple,
                'timer' => $questionData->timer,
            ]);

            $question->answers()->createMany(
                collect($questionData->answers)->map(fn ($answerData) => [
                    'content' => $answerData['content'],
                    'is_correct' => $answerData['is_correct'],
                ])->toArray()
            );
        }
    }

    public function createQuiz(CreateOrUpdateQuizData $data): void
    {
        $imageUrl = $this->storeQuizImage($data->icon, $data->title);

        DB::transaction(function () use ($data, $imageUrl) {
            $quiz = Quiz::create([
                'title' => $data->title,
                'description' => $data->description,
                'duration' => $data->duration,
                'difficulty_id' => $data->difficulty_id,
                'category_id' => $data->category_id,
                'is_published' => $data->is_published,
                'image_url' => $imageUrl,
                'author_id' => auth()->id(),
            ]);

            if (! empty($data->themes_ids)) {
                $quiz->themes()->sync($data->themes_ids);
            }

            $this->createQuestions($data, $quiz);
        });
    }

    public function updateQuiz(string $quizId, CreateOrUpdateQuizData $data): void
    {
        $quiz = Quiz::findOrFail($quizId);

        $imageUrl = $data->icon ? $this->storeQuizImage($data->icon, $data->title) : $quiz->image_url;

        DB::transaction(function () use ($data, $quiz, $imageUrl) {
            $quiz->fill([
                'title' => $data->title,
                'description' => $data->description,
                'duration' => $data->duration,
                'difficulty_id' => $data->difficulty_id,
                'category_id' => $data->category_id,
                'is_published' => $data->is_published,
                'image_url' => $imageUrl,
            ]);

            $data->themes_ids ? $quiz->themes()->sync($data->themes_ids) : $quiz->themes()->detach();

            $quiz->questions()->delete();

            $this->createQuestions($data, $quiz);
        });
    }

    public function setQuizPublicationStatus(string $quizId, PublishQuizData $data): void
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->is_published = $data->is_published;
        $quiz->save();
    }

    public function deleteQuiz(string $quizId): void
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->delete();
    }
}
