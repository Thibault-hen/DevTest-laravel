<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            UserSeeder::class,
            ThemeSeeder::class,
            CategorySeeder::class,
            DifficultySeeder::class,
            QuizSeeder::class,
        ]);
    }
}
