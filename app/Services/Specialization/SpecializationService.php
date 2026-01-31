<?php

declare(strict_types=1);

namespace App\Services\Specialization;

use App\Data\Specialization\CreateOrUpdateSpecializationData;
use App\Models\Specialization;
use App\Queries\Specialization\GetAllSpecializationsQuery;
use Illuminate\Support\Collection;

class SpecializationService
{
    public function __construct(private readonly GetAllSpecializationsQuery $getAllSpecializationsQuery) {}

    public function getAllSpecializations(): Collection
    {
        return $this->getAllSpecializationsQuery->execute();
    }

    public function createSpecialization(CreateOrUpdateSpecializationData $data): Specialization
    {
        $createdSpecialization = Specialization::create($data->toArray());

        return $createdSpecialization;
    }

    public function updateSpecialization(Specialization $specialization, CreateOrUpdateSpecializationData $data): Specialization
    {
        $specialization->update($data->toArray());

        return $specialization;
    }

    public function deleteSpecialization(Specialization $specialization): Specialization
    {
        $specializationData = $specialization;
        $specialization->delete();

        return $specializationData;
    }
}
