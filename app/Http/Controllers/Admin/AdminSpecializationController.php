<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Specialization\CreateOrUpdateSpecializationData;
use App\Data\Specialization\SpecializationData;
use App\Http\Controllers\Controller;
use App\Models\Specialization;
use App\Services\Specialization\SpecializationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminSpecializationController extends Controller
{
    public function __construct(private readonly SpecializationService $specializationService) {}

    public function index(): Response
    {
        $specializations = $this->specializationService->getAllSpecializations();

        return Inertia::render('admin/Specializations', [
            'specializations' => SpecializationData::collect($specializations),
        ]);
    }

    public function store(CreateOrUpdateSpecializationData $data): RedirectResponse
    {
        $this->specializationService->createSpecialization($data);

        return redirect()->route('admin.specializations');
    }

    public function update(Specialization $specialization, Request $request): RedirectResponse
    {
        $data = CreateOrUpdateSpecializationData::validateAndCreate([
            ...$request->all(),
            'id' => $specialization->id,
        ]);

        $this->specializationService->updateSpecialization($specialization, $data);

        return redirect()->route('admin.specializations');
    }

    public function destroy(Specialization $specialization): RedirectResponse
    {
        $this->specializationService->deleteSpecialization($specialization);

        return redirect()->route('admin.specializations');
    }
}
