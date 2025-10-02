<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasUuids;
    protected $table = 'quiz';
    public function difficulty(): BelongsTo
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class, 'quiz_theme', 'quiz_id', 'theme_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'quiz_tag', 'quiz_id', 'tag_id');
    }

    public function isPublished(): bool
    {
        return $this->is_published;
    }
}
