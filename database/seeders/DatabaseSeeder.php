<?php

declare(strict_types=1);

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
            SpecializationSeeder::class,
            AdminUserSeeder::class,
            UserSeeder::class,
            ThemeSeeder::class,
            CategorySeeder::class,
            DifficultySeeder::class,
            QuizSeeder::class,
        ]);
    }
}
