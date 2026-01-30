<?php

declare(strict_types=1);

namespace App\Data\Result;

use App\Data\Answer\AnswerResultData;
use App\Data\Quiz\QuizData;
use App\Data\Rating\RatingData;
use App\Data\User\UserData;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ResultData extends Data
{
    public function __construct(
        public string $id,
        public int $score,
        public int $completed_in,
        public int $correct_answers_count,

        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d H:i:s')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public ?Carbon $completed_at,

        #[DataCollectionOf(ResultQuestionData::class)]
        public DataCollection $results,

        #[DataCollectionOf(AnswerResultData::class)]
        public DataCollection $user_answers,

        public QuizData $quiz,
        public ?RatingData $user_rating,
        public ?UserData $user
    ) {}
}
