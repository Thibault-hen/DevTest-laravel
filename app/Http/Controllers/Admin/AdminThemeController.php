<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Theme\CreateOrUpdateThemeData;
use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Services\Theme\ThemeService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminThemeController extends Controller
{
    public function index(ThemeService $themeService)
    {
        $themes = $themeService->getAllThemes();

        return Inertia::render('admin/Themes', [
            'themes' => $themes,
        ]);
    }

    public function store(CreateOrUpdateThemeData $data, ThemeService $themeService)
    {
        $themeService->createTheme($data);

        return to_route('admin.themes');
    }

    public function update(Theme $theme, Request $request, ThemeService $themeService)
    {
        $data = CreateOrUpdateThemeData::validateAndCreate([
            ...$request->all(),
            'id' => $theme->id,
        ]);

        $themeService->updateTheme($theme, $data);

        return to_route('admin.themes');
    }

    public function destroy(Theme $theme, ThemeService $themeService)
    {
        $themeService->deleteTheme($theme);

        return to_route('admin.themes');
    }
}
