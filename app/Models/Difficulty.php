<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Difficulty extends Model
{
    use HasUuids;
    protected $table = 'difficulty';
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}
