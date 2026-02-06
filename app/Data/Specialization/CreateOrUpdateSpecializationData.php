<?php

declare(strict_types=1);

namespace App\Data\Specialization;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class CreateOrUpdateSpecializationData extends Data
{
    public function __construct(
        public string $name,
    ) {}

    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'name' => [
                Rule::unique('specializations', 'name')->ignore($context?->payload['id'] ?? null),
            ],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'name.required' => 'Le nom de la spécialisation est obligatoire.',
            'name.string' => 'Le nom de la spécialisation doit être une chaîne de caractères.',
            'name.unique' => 'Le nom de la spécialisation a déjà été pris.',
        ];
    }
}
