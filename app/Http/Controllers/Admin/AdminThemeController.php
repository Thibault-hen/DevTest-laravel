<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Theme\CreateOrUpdateThemeData;
use App\Http\Controllers\Controller;
use App\Models\Theme;
use App\Services\Theme\ThemeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminThemeController extends Controller
{
    public function __construct(private readonly ThemeService $themeService) {}

    public function index(): Response
    {
        $themes = $this->themeService->getAllThemes();

        return Inertia::render('admin/Themes', [
            'themes' => $themes,
        ]);
    }

    public function store(CreateOrUpdateThemeData $data): RedirectResponse
    {
        $this->themeService->createTheme($data);

        return to_route('admin.themes');
    }

    public function update(Theme $theme, Request $request): RedirectResponse
    {
        $data = CreateOrUpdateThemeData::validateAndCreate([
            ...$request->all(),
            'id' => $theme->id,
        ]);

        $this->themeService->updateTheme($theme, $data);

        return to_route('admin.themes');
    }

    public function destroy(Theme $theme): RedirectResponse
    {
        $this->themeService->deleteTheme($theme);

        return to_route('admin.themes');
    }
}
