<?php

declare(strict_types=1);

namespace App\Actions\Quiz;

use App\Data\Quiz\admin\CreateOrUpdateQuizData;
use App\Models\Quiz;
use DB;

class CreateQuizAction
{
    public function __construct(
        private readonly StoreQuizImageAction $storeQuizImage,
        private readonly CreateQuestionsAction $createQuestions,
    ) {}

    public function handle(CreateOrUpdateQuizData $data): void
    {
        $imageUrl = $this->storeQuizImage->handle($data->icon, $data->title);

        DB::transaction(function () use ($data, $imageUrl) {
            $quiz = Quiz::create([
                'title' => $data->title,
                'description' => $data->description,
                'duration' => $data->duration,
                'difficulty_id' => $data->difficulty_id,
                'category_id' => $data->category_id,
                'is_published' => $data->is_published,
                'image_url' => $imageUrl,
                'author_id' => auth()->id(),
            ]);

            if (! empty($data->themes_ids)) {
                $quiz->themes()->sync($data->themes_ids);
            }

            $this->createQuestions->handle($data, $quiz);
        });
    }
}
