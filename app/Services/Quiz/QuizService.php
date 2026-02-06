<?php

declare(strict_types=1);

namespace App\Services\Quiz;

use App\Actions\Quiz\CreateQuizAction;
use App\Actions\Quiz\UpdateQuizAction;
use App\Data\Category\CategoryData;
use App\Data\Difficulty\DifficultyData;
use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Data\Quiz\admin\PublishQuizData;
use App\Data\Quiz\QuizData;
use App\Data\Quiz\QuizPlayData;
use App\Data\Quiz\QuizzesData;
use App\Data\Theme\ThemeData;
use App\Enums\CacheKey;
use App\Enums\CacheTag;
use App\Models\Quiz;
use App\Queries\Quiz\GetAllQuizzesQuery;
use App\Queries\Quiz\GetMetaDataQuery;
use Illuminate\Support\Facades\Cache;
use Spatie\LaravelData\DataCollection;

class QuizService
{
    private const int CACHE_TTL = 3600;

    public function __construct(
        private readonly GetAllQuizzesQuery $getAllQuizzesQuery,
        private readonly GetMetaDataQuery $getMetaDataQuery,
        private readonly CreateQuizAction $createQuizAction,
        private readonly UpdateQuizAction $updateQuizAction,
    ) {}

    public function getQuizzesData(bool $withQuestions = false): QuizzesData
    {
        return Cache::tags([CacheTag::QUIZ->value])
            ->remember($withQuestions ? CacheKey::QUIZZES_WITH_QUESTIONS->value : CacheKey::QUIZZES->value,
                self::CACHE_TTL,
                fn () => $this->buildQuizzesData($withQuestions)
            );
    }

    private function buildQuizzesData(bool $withQuestions): QuizzesData
    {
        $quizzes = $this->getAllQuizzesQuery->execute($withQuestions);
        $metaData = $this->getMetaDataQuery->execute();

        return new QuizzesData(
            quizzes: QuizData::collect($quizzes, DataCollection::class),
            themes: ThemeData::collect($metaData['themes'], DataCollection::class),
            categories: CategoryData::collect($metaData['categories'], DataCollection::class),
            difficulties: DifficultyData::collect($metaData['difficulties'], DataCollection::class),
        );
    }

    public function getQuizDetails(Quiz $quiz): QuizData
    {
        return QuizData::from(
            Cache::tags([CacheTag::QUIZ->value])
                ->remember(CacheKey::QUIZ_DETAILS->value."_{$quiz->id}",
                    self::CACHE_TTL,
                    fn () => $quiz->loadQuizDetails()
                ));
    }

    public function getQuizPlay(Quiz $quiz): QuizPlayData
    {
        return QuizPlayData::from(
            Cache::tags([CacheTag::QUIZ->value])
                ->remember(CacheKey::QUIZ_PLAY->value."_{$quiz->id}",
                    self::CACHE_TTL,
                    fn () => $quiz->loadForPlaying()
                ));
    }

    public function createQuiz(CreateOrUpdateQuizData $data): void
    {
        $this->createQuizAction->handle($data);
    }

    public function updateQuiz(Quiz $quiz, CreateOrUpdateQuizData $data): void
    {
        $this->updateQuizAction->handle($quiz, $data);
    }

    public function setQuizPublicationStatus(Quiz $quiz, PublishQuizData $data): void
    {
        $quiz->is_published = $data->is_published;
        $quiz->save();
    }

    public function deleteQuiz(Quiz $quiz): void
    {
        $quiz->delete();
    }
}
