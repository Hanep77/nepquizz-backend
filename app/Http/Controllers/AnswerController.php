<?php

namespace App\Http\Controllers;

use App\Http\Resources\AnswerResource;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         "question_id" => ["required", "exists:questions,id"],
    //         "content" => ["required", "max:100"],
    //         "is_correct" => ["required", "boolean"],
    //     ]);

    //     $answer = Answer::query()->create($validated);

    //     return $answer;
    // }
}
