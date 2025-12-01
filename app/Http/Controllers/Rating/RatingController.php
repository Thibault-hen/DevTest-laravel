<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rating;

use App\Data\Rating\RatingPostData;
use App\Http\Controllers\Controller;
use App\Services\Rating\RatingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function store(Request $request, RatingService $ratingService): RedirectResponse
    {
        $validated = RatingPostData::validateAndCreate($request->all());

        if ($ratingService->hasUserRatedQuiz(auth()->id(), $validated->quiz_id)) {
            return back()->withErrors(['ratingAlreadyExists' => 'Vous avez déjà évalué ce quiz.']);
        }

        $ratingService->createRating($validated);

        return back()->with('success', 'Merci pour votre évaluation !');
    }
}
