<?php

declare(strict_types=1);

use App\Models\Answer;
use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Quiz Play', function () {
    it('should render quiz page with questions and answers', function () {
        $user = User::factory()->create();
        $this->actingAs($user);

        $quiz = Quiz::factory()
            ->for(User::factory(), 'author')
            ->for(Difficulty::factory())
            ->for(Category::factory())
            ->has(
                Question::factory()
                    ->has(Answer::factory()->count(4))
                    ->count(20)
            )
            ->create();

        $response = $this->get(route('quiz.play', $quiz));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->has('id')
            ->has('title')
            ->has('questions', 20)
            ->has('questions.0.shuffled_answers', 4)
        );
    });

    it('should loads quiz with correct data structure', function () {
        $quiz = Quiz::factory()
            ->has(
                Question::factory()
                    ->has(Answer::factory()->count(4))
                    ->count(20)
            )
            ->create();

        $quizDetails = $quiz->loadForPlaying();

        expect($quizDetails->questions)->toHaveCount(20);
        expect($quizDetails->questions->first()->answers)->toHaveCount(4);
    });
});
