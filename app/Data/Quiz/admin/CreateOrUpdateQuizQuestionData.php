<?php

declare(strict_types=1);

namespace App\Data\Quiz\admin;

use Closure;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
#[MergeValidationRules]
class CreateOrUpdateQuizQuestionData extends Data
{
    public function __construct(
        #[Min(5), Max(255)]
        public string $content,

        public bool $is_multiple,

        public int $timer,

        #[DataCollectionOf(CreateOrUpdateQuizAnswerData::class)]
        #[Min(4), Max(4)]
        public DataCollection $answers,
    ) {}

    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'answers' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    $hasCorrectAnswer = collect($value)->contains(fn ($answer) => $answer['is_correct'] == true || $answer['is_correct'] === '1');

                    if (! $hasCorrectAnswer) {
                        $fail('Au moins une réponse correcte doit être sélectionnée.');
                    }
                },
            ],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'content.min' => 'La question doit contenir au moins :min caractères.',
            'content.max' => 'La question ne peut pas dépasser :max caractères.',
            'content.required' => 'Le contenu de la question est requis.',
            'answers.min' => 'Une question doit contenir au moins :min réponses.',
            'answers.max' => 'Une question ne peut pas contenir plus de :max réponses.',
        ];
    }
}
