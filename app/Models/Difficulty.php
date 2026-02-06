<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\DifficultyObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(DifficultyObserver::class)]
class Difficulty extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'level',
        'color',
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
