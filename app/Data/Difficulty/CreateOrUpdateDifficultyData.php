<?php

declare(strict_types=1);

namespace App\Data\Difficulty;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\StartsWith;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class CreateOrUpdateDifficultyData extends Data
{
    public function __construct(
        #[Min(3), Max(50)]
        public string $level,
        #[Min(7), Max(7), StartsWith('#')]
        public ?string $color = null,
    ) {}

    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'level' => [
                Rule::unique('difficulties', 'level')->ignore($context?->payload['id'] ?? null),
            ],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'level.required' => 'Le niveau est obligatoire.',
            'level.string' => 'Le niveau doit être une chaîne de caractères.',
            'level.unique' => 'Le niveau a déjà été pris.',
            'level.min' => 'Le niveau doit contenir au moins :min caractères.',
            'level.max' => 'Le niveau ne doit pas dépasser :max caractères.',
            'color.min' => 'La couleur doit contenir au moins :min caractères.',
            'color.max' => 'La couleur ne doit pas dépasser :max caractères.',
            'color.starts_with' => 'La valeur de la couleur doit être hexadécimale et commencer par :values.',
        ];
    }
}
