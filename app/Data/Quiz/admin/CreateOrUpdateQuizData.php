<?php

declare(strict_types=1);

namespace App\Data\Quiz\admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Image;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Mimes;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Uuid;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class CreateOrUpdateQuizData extends Data
{
    public function __construct(
        #[Uuid]
        public ?string $id,

        #[Min(5), Max(100)]
        public string $title,

        #[Min(20), Max(255)]
        public string $description,

        #[Uuid]
        public string $difficulty_id,

        #[Uuid]
        public string $category_id,

        public ?array $themes_ids,

        public int $duration,

        public bool $is_published,

        #[Image, Mimes('webp', 'jpg', 'png'), Max(500)]
        public ?UploadedFile $icon,

        #[DataCollectionOf(CreateOrUpdateQuizQuestionData::class)]
        #[Min(20), Max(20)]
        public DataCollection $questions,
    ) {}

    public static function rules(?ValidationContext $context = null): array
    {
        return [
            'title' => [
                Rule::unique('quizzes', 'title')->ignore($context->payload['id'] ?? null),
            ],
        ];
    }

    public static function messages(...$args): array
    {
        return [
            'title.unique' => 'Ce titre de quiz est déjà utilisé.',
            'title.min' => 'Le titre doit contenir au moins :min caractères.',
            'title.max' => 'Le titre ne peut pas dépasser :max caractères.',
            'title.required' => 'Le titre du quiz est requis.',
            'description.min' => 'La description doit contenir au moins :min caractères.',
            'description.max' => 'La description ne peut pas dépasser :max caractères.',
            'description.required' => 'La description du quiz est requise.',
            'questions.min' => 'Un quiz doit contenir au moins :min questions.',
            'questions.max' => 'Un quiz ne peut pas contenir plus de :max questions.',
            'category_id.uuid' => 'Veuillez sélectionner une catégorie valide.',
            'category_id.required' => 'La catégorie du quiz est requise.',
            'difficulty_id.uuid' => 'Veuillez sélectionner une difficulté valide.',
            'difficulty_id.required' => 'La difficulté du quiz est requise.',
            'duration.required' => 'La durée du quiz est requise.',
            'icon.image' => 'Le fichier téléchargé doit être une image valide.',
            'icon.mimes' => "L'icône du quiz doit être au format :mimes.",
            'icon.max' => "L'icône du quiz ne peut pas dépasser :max kilooctets.",
        ];
    }
}
