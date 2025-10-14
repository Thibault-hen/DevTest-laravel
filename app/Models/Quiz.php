<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Quiz extends Model
{
    use HasUuids;
    protected $table = 'quiz';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration',
        'image_url',
        'image_text',
        'is_published',
        'difficulty_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'duration' => 'int',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($quiz) {
            if (empty($quiz->slug)) {
                $quiz->slug = Str::slug($quiz->title);
            }
        });

        static::saved(fn() => Cache::tags(['quiz'])->flush());
        static::deleted(fn() => Cache::tags(['quiz'])->flush());
    }

    public function difficulty(): BelongsTo
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function isPublished(): bool
    {
        return $this->is_published;
    }
}
