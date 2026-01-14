<?php

declare(strict_types=1);

namespace App\Data\Answer;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AnswerData extends Data
{
    public function __construct(
        public string $id,
        public string $content,
        public bool $is_correct
    ) {}
}
