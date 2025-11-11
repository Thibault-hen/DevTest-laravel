<?php

declare(strict_types=1);

namespace App\Http\Controllers\Result;

use App\Data\Result\ResultPostData;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Result;
use App\Services\Result\ResultService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ResultController extends Controller
{
    public function store(Request $request, Quiz $quiz, ResultService $resultService)
    {
        $resultData = ResultPostData::validateAndCreate($request->all());

        $result = $resultService->saveResult($quiz, $resultData, auth()->id());

        return redirect()->route('result.show', ['result' => $result->id])
            ->with('success', 'Merci d\'avoir participé ! Vos réponses ont été enregistrées avec succès.');
    }

    public function show(Request $request, Result $result, ResultService $resultService): Response
    {
        // TODO: Add authorization check (Policy)
        // $this->authorize('view', $result);
        $quizSummaryResult = $resultService->getQuizSummaryResult($result);

        return Inertia::render('result/Result', [
            'quiz_result' => $quizSummaryResult,
        ]);
    }
}
