<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\UserAnswer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserAnswerController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            "game_session_id" => ["required", "exists:game_sessions,id"],
            "answer_id" => ["required", "exists:answers,id"]
        ]);

        $answer = Answer::query()->find($validated["answer_id"]);
        $validated["question_id"] = $answer->question->id;

        $userAnswer = UserAnswer::query()->where([
            'game_session_id' => $validated['game_session_id'],
            'question_id' => $validated['question_id']
        ])->first();

        if ($userAnswer) {
            $userAnswer->update($validated);
        } else {
            $userAnswer = UserAnswer::query()->create($validated);
        }

        return response()->json($userAnswer);
    }
}
