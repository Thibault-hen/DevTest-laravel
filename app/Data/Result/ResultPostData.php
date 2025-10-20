<?php

declare(strict_types=1);

namespace App\Data\Result;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ResultPostData extends Data
{
    public function __construct(
        #[Required]
        public int $total_time,

        #[DataCollectionOf(QuestionAnswerData::class)]
        #[Required, ArrayType]
        public DataCollection $questions,
    ) {}
}

#[TypeScript]
class QuestionAnswerData extends Data
{
    public function __construct(
        #[Required, Uuid]
        public string $question_id,

        #[WithoutValidation]
        public string|array|null $answers = null,
    ) {}
}
