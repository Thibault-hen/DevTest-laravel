<?php

declare(strict_types=1);

namespace App\Data\Category;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateOrUpdateCategoryData extends Data
{
    public function __construct(
        #[Min(3), Max(50)]
        #[Unique('categories', 'title')]
        public string $title,
    ) {}

    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'title' => [
                Rule::unique('categories', 'title')->ignore($context->payload['id'] ?? null),
            ],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaîne de caractères.',
            'title.unique' => 'Le titre a déjà été pris.',
            'title.min' => 'Le titre doit contenir au moins :min caractères.',
            'title.max' => 'Le titre ne doit pas dépasser :max caractères.',
        ];
    }
}
