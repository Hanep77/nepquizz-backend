<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         "quiz_id" => ["required", "exists:quizzes,id"],
    //         "content" => ["required", "max:255"],
    //     ]);

    //     $question = Question::query()->create($validated);

    //     return new QuestionResource($question);
    // }
}
