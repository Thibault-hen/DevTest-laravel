<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('data/categories.json');

        if (! File::exists($jsonPath)) {
            $this->command->error("File not found: {$jsonPath}");

            return;
        }

        $categories = json_decode(File::get($jsonPath), true);

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
