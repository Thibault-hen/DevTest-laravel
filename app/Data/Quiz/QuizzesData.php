<?php

declare(strict_types=1);

namespace App\Data\Quiz;

use App\Data\Category\CategoryData;
use App\Data\Difficulty\DifficultyData;
use App\Data\Theme\ThemeData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuizzesData extends Data
{
    public function __construct(
        #[DataCollectionOf(QuizData::class)]
        public DataCollection $quizzes,

        #[DataCollectionOf(ThemeData::class)]
        public DataCollection $themes,

        #[DataCollectionOf(CategoryData::class)]
        public DataCollection $categories,

        #[DataCollectionOf(DifficultyData::class)]
        public DataCollection $difficulties,
    ) {}
}
