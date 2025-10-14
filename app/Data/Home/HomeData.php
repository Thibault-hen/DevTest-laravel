<?php

declare(strict_types=1);

namespace App\Data\Home;

use App\Data\Quiz\QuizData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class HomeData extends Data
{
    public function __construct(
        #[DataCollectionOf(QuizData::class)]
        public ?DataCollection $quizzes,
        public int $quizCount,
        public int $quizCompletedCount,
        public int $themeCount
    ) {}
}
