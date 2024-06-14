<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = Question::all();

        foreach ($questions as $question) {
            for ($i = 1; $i <= 4; $i++) {
                Answer::factory()->create([
                    "question_id" => $question['id'],
                    "content" => "answer $i",
                    "is_correct" => $i == 3
                ]);
            }
        }
    }
}
