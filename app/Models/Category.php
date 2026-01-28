<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasUuids;

    protected $fillable = [
        'title',
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
