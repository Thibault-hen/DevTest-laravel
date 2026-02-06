<?php

declare(strict_types=1);

namespace App\Data\Quiz;

use App\Data\Author\AuthorData;
use App\Data\Category\CategoryData;
use App\Data\Difficulty\DifficultyData;
use App\Data\Question\QuestionPlayData;
use App\Data\Theme\ThemeData;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuizPlayData extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public string $slug,
        public string $description,
        public int $duration,
        public ?string $image_url,
        public ?string $image_text,

        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y')]
        public ?Carbon $created_at,

        public ?AuthorData $author = null,
        public ?DifficultyData $difficulty = null,
        public ?CategoryData $category = null,

        #[DataCollectionOf(ThemeData::class)]
        public ?DataCollection $themes = null,

        #[DataCollectionOf(QuestionPlayData::class)]
        public ?DataCollection $questions = null,
    ) {}
}
