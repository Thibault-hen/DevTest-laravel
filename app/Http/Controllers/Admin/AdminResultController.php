<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Services\Result\ResultService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminResultController extends Controller
{
    public function index(Request $request, ResultService $resultService): Response
    {
        $results = $resultService->getAllQuizSummaryResults();

        return Inertia::render('admin/Results', [
            'results' => $results,
        ]);
    }

    public function destroy(Result $result): RedirectResponse
    {
        $result->delete();

        return redirect()->route('admin.results');
    }
}
