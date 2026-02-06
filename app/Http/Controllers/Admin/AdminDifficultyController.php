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
    public function __construct(private readonly DifficultyService $difficultyService) {}

    public function index(): Response
    {
        $difficulties = $this->difficultyService->getAllDifficulties();

        return Inertia::render('admin/Difficulties', [
            'difficulties' => $difficulties,
        ]);
    }

    public function store(CreateOrUpdateDifficultyData $data): RedirectResponse
    {
        $this->difficultyService->createDifficulty($data);

        return to_route('admin.difficulties');
    }

    public function update(Difficulty $difficulty, Request $request): RedirectResponse
    {
        $data = CreateOrUpdateDifficultyData::validateAndCreate([
            ...$request->all(),
            'id' => $difficulty->id,
        ]);

        $this->difficultyService->updateDifficulty($data, $difficulty);

        return to_route('admin.difficulties');
    }

    public function destroy(Difficulty $difficulty): RedirectResponse
    {
        $this->difficultyService->deleteDifficulty($difficulty);

        return to_route('admin.difficulties');
    }
}
