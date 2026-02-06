<?php

declare(strict_types=1);
use App\Models\Category;
use App\Models\Difficulty;
use App\Models\Quiz;
use App\Models\Theme;
use App\Models\User;
use App\Services\Home\HomeService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Homepage', function () {
    it('should render homepage with home data', function () {
        $response = $this->get(route('home'));

        Quiz::factory()
            ->for(User::factory(), 'author')
            ->for(Difficulty::factory())
            ->for(Category::factory())
            ->count(3)
            ->create();

        Category::factory()->count(2)->create();
        Difficulty::factory()->count(2)->create();

        $themes = Theme::factory()->count(4)->create();

        Quiz::all()->each(fn ($quiz) => $quiz->themes()->attach($themes));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->has('quizzes')
            ->has('quiz_count')
            ->has('theme_count')
            ->has('quiz_completed_count')
        );
    });

    it('returns home data with quizzes and stats', function () {
        $quizzes = Quiz::factory()
            ->for(User::factory(), 'author')
            ->for(Difficulty::factory())
            ->for(Category::factory())
            ->count(3)
            ->create();

        $themes = Theme::factory()->count(4)->create();
        $quizzes->each(fn ($quiz) => $quiz->themes()->attach($themes));

        $service = app(HomeService::class);
        $data = $service->getHomeData();

        expect($data->quizzes)->toHaveCount(3);
        expect($data->quizCount)->toBe(3);
        expect($data->themeCount)->toBe(4);
        expect($data->quizCompletedCount)->toBe(0);
    });
});
