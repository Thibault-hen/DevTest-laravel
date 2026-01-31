<?php

declare(strict_types=1);

namespace App\Actions\Quiz;

use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Models\Quiz;
use DB;

class UpdateQuizAction
{
    public function __construct(
        private readonly StoreQuizImageAction $storeQuizImageAction,
    ) {}

    public function handle(Quiz $quiz, CreateOrUpdateQuizData $data): void
    {
        $imageUrl = $data->icon ? $this->storeQuizImageAction->handle($data->icon, $data->title) : $quiz->image_url;

        DB::transaction(function () use ($data, $quiz, $imageUrl) {
            $quiz->fill([
                'title' => $data->title,
                'description' => $data->description,
                'duration' => $data->duration,
                'difficulty_id' => $data->difficulty_id,
                'category_id' => $data->category_id,
                'is_published' => $data->is_published,
                'image_url' => $imageUrl,
            ]);
            $quiz->save();

            $data->themes_ids ? $quiz->themes()->sync($data->themes_ids) : $quiz->themes()->detach();

            collect($data->questions)->map(function ($questionData) use ($quiz) {
                $question = $quiz->questions()->updateOrCreate(
                    ['id' => $questionData['id'] ?? null],
                    [
                        'content' => $questionData['content'],
                        'is_multiple' => $questionData['is_multiple'],
                        'timer' => $questionData['timer'],
                    ]
                );

                foreach ($questionData['answers'] as $answerData) {
                    $question->answers()->updateOrCreate(
                        ['id' => $answerData['id'] ?? null],
                        [
                            'content' => $answerData['content'],
                            'is_correct' => $answerData['is_correct'],
                        ]
                    );
                }
            });
        });
    }
}
