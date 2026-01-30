<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theme extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
    ];

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'quiz_theme', 'theme_id', 'quiz_id');
    }
}
