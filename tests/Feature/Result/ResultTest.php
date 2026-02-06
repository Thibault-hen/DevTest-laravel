<?php

declare(strict_types=1);

use App\Data\Result\QuestionAnswerData;
use App\Data\Result\ResultPostData;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Result;
use App\Models\ResultUserAnswer;
use App\Models\User;
use App\Services\Result\ResultService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\LaravelData\DataCollection;

uses(RefreshDatabase::class);

describe('Quiz Submission', function () {
    it('should saves quiz result with user answers', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $quiz = Quiz::factory()->create();
        $question = Question::factory()->for($quiz)->create();
        $correctAnswer = Answer::factory()->for($question)->create(['is_correct' => true]);
        Answer::factory()->for($question)->create(['is_correct' => false]);

        $resultData = new ResultPostData(
            60,
            new DataCollection(QuestionAnswerData::class,
                [
                    new QuestionAnswerData($question->id, [$correctAnswer->id]),
                ])
        );

        $result = app(ResultService::class)->saveResult($quiz, $resultData, $user->id);

        expect($result->quiz_id)->toBe($quiz->id);
        expect($result->user_id)->toBe($user->id);
        expect($result->resultUserAnswers)->toHaveCount(1);
    });
});

describe('Result Page', function () {
    it('should retrieves quiz result summary with answers', function () {
        $user = User::factory()->create();
        $quiz = Quiz::factory()->create();
        $question = Question::factory()->for($quiz)->create();
        $answer = Answer::factory()->for($question)->create(['is_correct' => true]);

        $result = Result::factory()->for($quiz)->for($user)->create();
        ResultUserAnswer::factory()->for($result)->for($answer)->create();

        $data = app(ResultService::class)->getQuizSummaryResult($result);

        expect($data->quiz)->not->toBeNull();
        expect($data->user_answers)->toHaveCount(1);
    });

    it('should only allow result owner to view the result', function () {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $quiz = Quiz::factory()->create();
        $result = Result::factory()->for($quiz)->for($user)->create();

        $this->actingAs($otherUser)
            ->get(route('result.show', ['result' => $result->id]))
            ->assertForbidden();
    });

    it('should allow admin users to view anyone\'s result', function () {
        $user = User::factory()->create();
        $adminUser = User::factory()->setAdmin()->create();
        $quiz = Quiz::factory()->create();
        $result = Result::factory()->for($quiz)->for($user)->create();

        $this->actingAs($adminUser)
            ->get(route('result.show', ['result' => $result->id]))
            ->assertOk();
    });
});
