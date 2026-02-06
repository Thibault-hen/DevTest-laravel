<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userCount = 25;

        User::factory()->count($userCount)->create();

        $this->command->info("$userCount users created successfully.");
    }
}
