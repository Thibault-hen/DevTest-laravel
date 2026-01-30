<?php

declare(strict_types=1);

namespace App\Data\Specialization;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class SpecializationData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i:s')]
        public ?Carbon $created_at = null,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i:s')]
        public ?Carbon $updated_at = null,
    ) {}
}
