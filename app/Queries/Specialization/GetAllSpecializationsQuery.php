<?php

declare(strict_types=1);

namespace App\Queries\Specialization;

use App\Models\Specialization;
use Illuminate\Support\Collection;

final class GetAllSpecializationsQuery
{
    public function execute(): Collection
    {
        $specializations = Specialization::withCount('users')->get();

        return $specializations;
    }
}
