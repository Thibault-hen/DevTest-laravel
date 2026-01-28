<?php

declare(strict_types=1);

namespace App\Services\Theme;

use App\Data\Theme\CreateOrUpdateThemeData;
use App\Data\Theme\ThemeData;
use App\Models\Theme;
use Spatie\LaravelData\DataCollection;

class ThemeService
{
    public function getAllThemes(): DataCollection
    {
        $themes = Theme::all();
        $themes->loadCount('quizzes');

        return ThemeData::collect($themes, DataCollection::class);
    }

    public function createTheme(CreateOrUpdateThemeData $themeData): ThemeData
    {
        $theme = Theme::create($themeData->toArray());

        return ThemeData::from($theme);
    }

    public function updateTheme(Theme $theme, CreateOrUpdateThemeData $themeData): ThemeData
    {
        $theme->title = $themeData->title;
        $theme->save();

        return ThemeData::from($theme->refresh());
    }

    public function deleteTheme(Theme $theme): ThemeData
    {
        $themeData = ThemeData::from($theme);
        $theme->delete();

        return $themeData;
    }
}
