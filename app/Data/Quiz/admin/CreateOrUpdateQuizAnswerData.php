<?php

declare(strict_types=1);

namespace App\Data\Quiz\admin;

use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateOrUpdateQuizAnswerData extends Data
{
    public function __construct(
        #[Uuid]
        public ?string $id,
        #[Min(1), Max(255)]
        public string $content,

        public bool $is_correct,
    ) {}

    public static function messages(...$args): array
    {
        return [
            'content.min' => 'La réponse doit contenir au moins :min caractères.',
            'content.max' => 'La réponse ne peut pas dépasser :max caractères.',
            'content.required' => 'Le contenu de la réponse est requis.',
        ];
    }
}
