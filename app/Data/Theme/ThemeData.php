<?php

declare(strict_types=1);

namespace App\Data\Theme;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class ThemeData extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y')]
        public ?Carbon $created_at = null,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y')]
        public ?Carbon $updated_at = null,
        public ?int $quizzes_count = null,
    ) {}
}
