<?php

declare(strict_types=1);

namespace App\Data\Category;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CategoryData extends Data
{
    public function __construct(
        public string $id,
        public string $title,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
        public ?int $quizzes_count = null,
    ) {}
}
