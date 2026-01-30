<?php

declare(strict_types=1);

namespace App\Data\User;

use App\Data\Specialization\SpecializationData;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserRatingData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public ?SpecializationData $specialization,
        public ?string $avatar = null,
    ) {}
}
