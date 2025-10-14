<?php
namespace App\Data\Author;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript]
class AuthorData extends Data
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}