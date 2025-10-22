<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasUuids, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = ['full_avatar_url'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the full avatar URL with /storage/ prefix
     */
    public function getFullAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar) {
            return null;
        }

        // If already starts with /storage/, return as is
        if (str_starts_with($this->avatar, '/storage/')) {
            return $this->avatar;
        }

        // If starts with http/https, it's an external URL
        if (str_starts_with($this->avatar, 'http')) {
            return $this->avatar;
        }

        // Otherwise, prepend /storage/
        return '/storage/' . $this->avatar;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
