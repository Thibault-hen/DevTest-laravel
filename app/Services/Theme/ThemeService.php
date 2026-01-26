<?php

declare(strict_types=1);

namespace App\Services\Theme;

use App\Data\Theme\CreateOrUpdateThemeData;
use App\Data\Theme\ThemeData;
use App\Models\Theme;
use Spatie\LaravelData\DataCollection;

class ThemeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getAllThemes(): DataCollection
    {
        $themes = Theme::all();
        $themes->loadCount('quizzes');

        return ThemeData::collect($themes, DataCollection::class);
    }

    public function createTheme(CreateOrUpdateThemeData $themeData): void
    {
        Theme::create([
            'title' => $themeData->title,
        ]);
    }

    public function updateTheme(Theme $theme, CreateOrUpdateThemeData $themeData): void
    {
        $theme->title = $themeData->title;
        $theme->save();
    }

    public function deleteTheme(Theme $theme): void
    {
        $theme->delete();
    }
}
