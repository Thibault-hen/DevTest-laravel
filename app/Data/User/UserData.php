<?php

declare(strict_types=1);

namespace App\Data\User;

use App\Data\Specialization\SpecializationData;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class UserData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public ?SpecializationData $specialization,
        public ?string $avatar = null,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i:s')]
        public ?Carbon $created_at = null,
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'd-m-Y H:i:s')]
        public ?Carbon $updated_at = null,
        public ?string $email_verified_at = null,
        public ?string $two_factor_confirmed_at = null,
        public bool $is_admin = false,
    ) {}
}
