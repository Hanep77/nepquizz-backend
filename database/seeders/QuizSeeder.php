<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::query()->where('name', '=', 'Yudis Sutisna')->first();
        $user2 = User::query()->where('name', '=', 'Test User')->first();

        Quiz::factory()->create([
            "user_id" => $user1,
            "category_id" => 1,
            "difficulity_id" => 1,
            "title" => "javascript for basic",
            "description" => "test your javascript basic knowledge"
        ]);

        Quiz::factory()->create([
            "user_id" => $user2,
            "category_id" => 3,
            "difficulity_id" => 2,
            "title" => "algebra quiz",
            "description" => "test your algebra knowledge"
        ]);

        Quiz::factory()->create([
            "user_id" => $user2,
            "category_id" => 2,
            "difficulity_id" => 3,
            "title" => "guess 1940s footballer",
            "description" => "test your football knowledge"
        ]);
    }
}
