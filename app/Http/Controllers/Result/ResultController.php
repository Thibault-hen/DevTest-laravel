<?php

declare(strict_types=1);

namespace App\Http\Controllers\Result;

use App\Data\Result\ResultPostData;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Result;
use App\Services\Result\ResultService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ResultController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private readonly ResultService $resultService) {}

    public function store(Request $request, Quiz $quiz): RedirectResponse
    {
        $resultData = ResultPostData::validateAndCreate($request->all());

        $result = $this->resultService->saveResult($quiz, $resultData, auth()->id());

        return to_route('result.show', ['result' => $result->id])
            ->with('success', 'Merci d\'avoir participé ! Vos réponses ont été enregistrées avec succès.');
    }

    public function show(Result $result): Response
    {
        $this->authorize('view', $result);

        $quizSummaryResult = $this->resultService->getQuizSummaryResult($result);

        return Inertia::render('result/Result', [
            'quiz_result' => $quizSummaryResult,
        ]);
    }
}
