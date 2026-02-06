<?php

declare(strict_types=1);

namespace App\Data\Rating;

use App\Data\User\UserRatingData;
use Illuminate\Support\Carbon;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class RatingData extends Data
{
    public function __construct(
        public string $id,
        public ?string $comment,
        public int $score,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
        public ?UserRatingData $user = null,
    ) {}
}
