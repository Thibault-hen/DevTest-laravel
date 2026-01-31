<?php

declare(strict_types=1);

namespace App\Services\Difficulty;

use App\Data\Difficulty\CreateOrUpdateDifficultyData;
use App\Data\Difficulty\DifficultyData;
use App\Models\Difficulty;
use App\Queries\Difficulty\GetAllDifficultiesQuery;
use Illuminate\Support\Collection;

final class DifficultyService
{
    public function __construct(private readonly GetAllDifficultiesQuery $getAllDifficultiesQuery) {}

    public function getAllDifficulties(): Collection
    {
        $difficulties = $this->getAllDifficultiesQuery->execute();

        return DifficultyData::collect($difficulties);
    }

    public function createDifficulty(CreateOrUpdateDifficultyData $data): DifficultyData
    {
        $difficulty = Difficulty::create($data->toArray());

        return DifficultyData::from($difficulty);
    }

    public function updateDifficulty(CreateOrUpdateDifficultyData $data, Difficulty $difficulty): DifficultyData
    {
        $difficulty->update($data->toArray());

        return DifficultyData::from($difficulty->refresh());
    }

    public function deleteDifficulty(Difficulty $difficulty): DifficultyData
    {
        $difficultyData = DifficultyData::from($difficulty);
        $difficulty->delete();

        return $difficultyData;
    }
}
