<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\Models\GameSession;
use App\Models\Quiz;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class GameSessionController extends Controller
{
    public function start_session(Request $request)
    {
        $validated = $request->validate([
            "user_id" => ["required", "exists:users,id"],
            "quiz_id" => ["required", "exists:quizzes,id"]
        ]);

        $oldGameSession = GameSession::query()->where($validated)->first();
        if ($oldGameSession) {
            return response()->json($oldGameSession);
        }

        $validated["start_at"] = now();

        $gameSession = GameSession::query()->create($validated);

        return response()->json($gameSession);
    }

    public function get_session($id)
    {
        $gameSession = GameSession::query()->with("quiz", function ($query) {
            $query->with('questions', function ($query) {
                $query->with('answers');
            });
        })->find($id);

        if (!$gameSession) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }

        return new QuizResource($gameSession->quiz);
    }

    public function get_user_answers($id)
    {
        $gameSession = GameSession::query()->find($id);

        if (!$gameSession) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }

        return response()->json($gameSession->userAnswers);
    }
}
