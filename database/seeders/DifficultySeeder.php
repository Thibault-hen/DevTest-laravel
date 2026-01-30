<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Difficulty;
use Illuminate\Database\Seeder;

class DifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Difficulty::factory()->count(3)->create();
    }
}
