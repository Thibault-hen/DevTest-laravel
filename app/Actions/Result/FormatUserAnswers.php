<?php

declare(strict_types=1);

namespace App\Actions\Result;

use App\Data\Result\ResultPostData;

final class FormatUserAnswers
{
    public function handle(ResultPostData $resultData): array
    {
        return $resultData->questions->toCollection()
            ->map(function ($answer) {
                if (empty($answer->answers)) {
                    return [
                        ['answer_id' => null],
                    ];
                }

                return collect((array) $answer->answers)
                    ->map(fn ($ans) => ['answer_id' => $ans])
                    ->toArray();
            })
            ->flatten(1)
            ->toArray();
    }
}
