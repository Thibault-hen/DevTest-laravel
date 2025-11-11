<?php

declare(strict_types=1);

namespace App\Data\Result;

use App\Data\Question\QuestionResultData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ResultQuestionData extends Data
{
    public function __construct(
        public QuestionResultData $question,
        public bool $is_correct
    ) {}
}
