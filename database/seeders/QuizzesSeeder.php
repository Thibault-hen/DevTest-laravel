<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Tag;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class QuizzesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/quizzes.json');

        if (!File::exists($jsonPath)) {
            $this->command->error("File not found: {$jsonPath}");
            return;
        }

        $quizzes = json_decode(File::get($jsonPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Invalid JSON format: ' . json_last_error_msg());
            return;
        }

        if (empty($quizzes)) {
            $this->command->warn('No quizzes found in JSON file');
            return;
        }

        $users = User::factory(5)->create();

        $difficulties = Difficulty::pluck('id');
        $themeIds = Theme::pluck('id', 'title');
        $tagsIds = Tag::pluck('id', 'name');

        foreach ($quizzes as $quizData) {
            $quiz = Quiz::create([
                'title' => $quizData['title'],
                'description' => $quizData['description'],
                'duration' => $quizData['duration'],
                'is_published' => $quizData['is_published'],
                'image_url' => $quizData['image_url'] ?? null,
                'image_text' => $quizData['image_text'] ?? null,
                'author_id' => $users->random()->id,
                'difficulty_id' => $difficulties->random(),
            ]);

            $quiz->themes()->sync(collect($quizData['themes'] ?? [])
                ->map(fn($themeName) => $themeIds[$themeName])
                ->filter());

            $quiz->tags()->sync(collect($quizData['tags'] ?? [])
                ->map(fn($tagName) => $tagsIds[$tagName])
                ->filter());

            foreach ($quizData['questions'] as $questionData) {
                $answers = $questionData['answers'] ?? [];
                unset($questionData['answers']);

                $question = $quiz->questions()->create($questionData);

                $answers = $question->answers()->createMany($answers);
            }
        }

        $totalQuizzes = Quiz::count();
        $totalQuestions = Question::count();
        $totalAnswers = Answer::count();

        $this->command->info("✅ Seeding completed.");
        $this->command->info("{$totalQuizzes} quizzes created");
        $this->command->info("{$totalQuestions} questions created");
        $this->command->info("{$totalAnswers} answers created");
    }
}
