<?php

declare(strict_types=1);

namespace App\Data\Question;

use App\Data\Answer\AnswerPlayData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuestionPlayData extends Data
{
    public function __construct(
        public string $id,
        public string $content,
        public int $timer,
        public bool $is_multiple,

        #[DataCollectionOf(AnswerPlayData::class)]
        public DataCollection $shuffledAnswers
    ) {}
}
