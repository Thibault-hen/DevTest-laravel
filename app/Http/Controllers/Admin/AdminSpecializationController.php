<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Data\Specialization\CreateOrUpdateSpecializationData;
use App\Data\Specialization\SpecializationData;
use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminSpecializationController extends Controller
{
    public function index(): Response
    {
        $specializations = Specialization::withCount('users')->get();

        return Inertia::render('admin/Specializations', [
            'specializations' => SpecializationData::collect($specializations),
        ]);
    }

    public function store(CreateOrUpdateSpecializationData $data): RedirectResponse
    {
        Specialization::create($data->toArray());

        return redirect()->route('admin.specializations');
    }

    public function update(Specialization $specialization, Request $request): RedirectResponse
    {
        $data = CreateOrUpdateSpecializationData::validateAndCreate([
            ...$request->all(),
            'id' => $specialization->id,
        ]);

        $specialization->update($data->toArray());

        return redirect()->route('admin.specializations');
    }

    public function destroy(Specialization $specialization): RedirectResponse
    {
        $specialization->delete();

        return redirect()->route('admin.specializations');
    }
}
