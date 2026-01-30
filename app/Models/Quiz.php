<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\Quiz\QuizObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(QuizObserver::class)]
class Quiz extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'duration',
        'image_url',
        'is_published',
        'category_id',
        'difficulty_id',
        'author_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'duration' => 'int',
    ];

    public function difficulty(): BelongsTo
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->oldest('created_at');
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

    /**
     * Load quiz details for viewing (show page - before playing)
     */
    public function loadQuizDetails(): Quiz
    {
        return $this->load('author', 'difficulty', 'themes', 'category', 'ratings.user.specialization')
            ->loadAvg('ratings', 'score')
            ->loadCount('ratings');
    }

    /**
     * Load quiz with questions and answers for playing
     */
    public function loadForPlaying(): Quiz
    {
        return $this->load('questions.shuffledAnswers', 'themes', 'difficulty', 'category', 'author');
    }
}
