<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Difficulty\CreateOrUpdateDifficultyData;
use App\Http\Controllers\Controller;
use App\Models\Difficulty;
use App\Services\Difficulty\DifficultyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDifficultyController extends Controller
{
    public function index(DifficultyService $difficultyService): Response
    {
        $difficulties = $difficultyService->getAllDifficulties();

        return Inertia::render('admin/Difficulties', [
            'difficulties' => $difficulties,
        ]);
    }

    public function store(CreateOrUpdateDifficultyData $data, DifficultyService $difficultyService): RedirectResponse
    {
        $difficultyService->createDifficulty($data);

        return to_route('admin.difficulties');
    }

    public function update(Difficulty $difficulty, Request $request, DifficultyService $difficultyService): RedirectResponse
    {
        $data = CreateOrUpdateDifficultyData::validateAndCreate([
            ...$request->all(),
            'id' => $difficulty->id,
        ]);

        $difficultyService->updateDifficulty($data, $difficulty);

        return to_route('admin.difficulties');
    }

    public function destroy(DifficultyService $difficultyService, Difficulty $difficulty): RedirectResponse
    {
        $difficultyService->deleteDifficulty($difficulty);

        return to_route('admin.difficulties');
    }
}
