<?php

declare(strict_types=1);

namespace App\Actions\Quiz;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class StoreQuizImageAction
{
    public function handle(?UploadedFile $icon, ?string $title): ?string
    {
        if (! $icon) {
            return null;
        }

        $fileName = Str::slug(($title ?? 'quiz-icon').'-'.time()).'.'.$icon->guessExtension();
        $path = $icon->storeAs('icons', $fileName, 'public');

        return Storage::url($path);
    }
}
