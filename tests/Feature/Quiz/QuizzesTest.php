<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Quiz;
use App\Models\Theme;
use App\Models\User;
use App\Services\Quiz\QuizService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Quizzes Page', function () {
    it('should render quizzes page with data', function () {
        Quiz::factory()
            ->for(User::factory(), 'author')
            ->for(Difficulty::factory())
            ->for(Category::factory())
            ->hasAttached(Theme::factory()->count(4))
            ->create();

        $response = $this->get(route('quizzes'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->has('quizzes', 1)
            ->has('themes', 4)
            ->has('categories')
            ->has('difficulties')
        );
    });

    it('should loads quizzes with correct data structure', function () {
        Quiz::factory()
            ->for(User::factory(), 'author')
            ->count(3)
            ->create();

        Theme::factory()->count(4)->create();

        $service = app(QuizService::class);

        $data = $service->getQuizzesData();

        expect($data->quizzes)->toHaveCount(3);
        expect($data->categories)->toHaveCount(3);
        expect($data->difficulties)->toHaveCount(3);
        expect($data->themes)->toHaveCount(4);
    });
});
