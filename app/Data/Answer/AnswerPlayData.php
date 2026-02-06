<?php

declare(strict_types=1);

namespace App\Data\Answer;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AnswerPlayData extends Data
{
    public function __construct(
        public string $id,
        public string $content,
    ) {}
}
