<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultUserAnswer extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'results_answers';

    protected $fillable = [
        'answer_id',
    ];

    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
