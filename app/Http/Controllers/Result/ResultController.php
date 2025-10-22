<?php

declare(strict_types=1);

namespace App\Http\Controllers\Result;

use App\Data\Result\ResultPostData;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Services\Result\ResultService;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function store(Request $request, Quiz $quiz, ResultService $resultService)
    {
        $resultData = ResultPostData::validateAndCreate($request->all());

        $resultService->saveResult($quiz, $resultData, auth()->id());
    }
}
