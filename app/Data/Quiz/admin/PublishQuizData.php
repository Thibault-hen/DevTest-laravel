<?php

declare(strict_types=1);

namespace App\Data\Quiz\admin;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class PublishQuizData extends Data
{
    public function __construct(
        public bool $is_published,
    ) {}
}
