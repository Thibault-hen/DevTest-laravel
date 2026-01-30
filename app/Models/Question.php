<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'content',
        'is_multiple',
        'timer',
    ];

    protected $casts = [
        'is_multiple' => 'boolean',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function shuffledAnswers(): HasMany
    {
        return $this->hasMany(Answer::class)->inRandomOrder();
    }
}
