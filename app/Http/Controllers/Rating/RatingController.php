<?php

declare(strict_types=1);

namespace App\Http\Controllers\Rating;

use App\Data\Rating\RatingPostData;
use App\Http\Controllers\Controller;
use App\Services\Rating\RatingService;
use Illuminate\Http\RedirectResponse;

class RatingController extends Controller
{
    public function store(RatingPostData $data, RatingService $ratingService): RedirectResponse
    {
        if ($ratingService->hasUserRatedQuiz(auth()->id(), $data->quiz_id)) {
            return back()->withErrors(['ratingAlreadyExists' => 'Vous avez déjà évalué ce quiz.']);
        }

        $ratingService->createRating($data);

        return back()->with('success', 'Merci pour votre évaluation !');
    }
}
