<?php

declare(strict_types=1);

namespace App\Data\Question;

use App\Data\Answer\AnswerData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class QuestionData extends Data
{
    public function __construct(
        public string $id,
        public string $content,
        public bool $is_multiple,
        public int $timer,

        #[DataCollectionOf(AnswerData::class)]
        public DataCollection $answers,
    ) {}
}
