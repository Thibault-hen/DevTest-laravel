<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Result extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'completed_in',
        'score',
        'user_id',
        'correct_answers_count',
    ];

    protected $cast = [
        'completed_at' => 'datetime',
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function resultUserAnswers(): HasMany
    {
        return $this->hasMany(ResultUserAnswer::class, 'result_id');
    }
}
