<?php

declare(strict_types=1);

namespace App\Data\Rating;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RatingPostData extends Data
{
    public function __construct(
        #[Max(300)]
        public ?string $comment,

        #[Min(1), Max(5)]
        public int $score,

        public string $quiz_id,
    ) {}
}
