<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quizzes = Quiz::all(['id']);

        foreach ($quizzes as $quiz) {
            for ($i = 1; $i <= 10; $i++) {
                Question::factory()->create([
                    "quiz_id" => $quiz['id'],
                    "content" => "question no $i"
                ]);
            }
        }
    }
}
