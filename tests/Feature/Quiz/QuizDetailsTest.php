<?php

declare(strict_types=1);

use App\Data\Quiz\QuizData;
use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Quiz;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Quiz details Page', function () {
    it('should render quiz details page with data', function () {
        $quiz = Quiz::factory()
            ->for(User::factory(), 'author')
            ->for(Difficulty::factory())
            ->for(Category::factory())
            ->hasAttached(Theme::factory()->count(4))
            ->create([
                'title' => 'Test quiz',
                'slug' => 'test-quiz',
            ]);

        $response = $this->get(route('quiz', $quiz));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->has('id')
            ->where('title', 'Test quiz')
            ->where('slug', 'test-quiz')
        );
    });

    it('should loads quiz details with correct data structure', function () {
        $quiz = Quiz::factory()
            ->for(User::factory(), 'author')
            ->for(Difficulty::factory())
            ->for(Category::factory())
            ->hasAttached(Theme::factory()->count(4))
            ->create([
                'title' => 'Test quiz',
                'slug' => 'test-quiz',
                'is_published' => false,
            ]);

        QuizData::from($quiz->loadQuizDetails());

        expect($quiz->title)->toBe('Test quiz');
        expect($quiz->slug)->toBe('test-quiz');
        expect($quiz->is_published)->toBeFalse();
    });
});
