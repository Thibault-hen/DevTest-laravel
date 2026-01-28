<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Difficulty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DifficultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/difficulties.json');

        if (! File::exists($jsonPath)) {
            $this->command->error("File not found: {$jsonPath}");

            return;
        }

        $difficulties = json_decode(File::get($jsonPath), true);

        foreach ($difficulties as $difficulty) {
            Difficulty::create($difficulty);
        }
    }
}
