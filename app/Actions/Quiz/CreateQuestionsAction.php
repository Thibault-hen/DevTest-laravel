<?php

declare(strict_types=1);

namespace App\Actions\Quiz;

use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Models\Quiz;

final class CreateQuestionsAction
{
    public function handle(CreateOrUpdateQuizData $data, Quiz $quiz): void
    {
        foreach ($data->questions as $questionData) {
            $question = $quiz->questions()->create([
                'content' => $questionData->content,
                'is_multiple' => $questionData->is_multiple,
                'timer' => $questionData->timer,
            ]);

            $question->answers()->createMany(
                collect($questionData->answers)->map(fn ($answerData) => [
                    'content' => $answerData['content'],
                    'is_correct' => $answerData['is_correct'],
                ])->toArray()
            );
        }
    }
}
