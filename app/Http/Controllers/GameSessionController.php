<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameSessionResouce;
use App\Http\Resources\UserAnswerResouce;
use App\Models\GameSession;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameSessionController extends Controller
{
    public function start_session(Request $request): GameSessionResouce
    {
        $validated = $request->validate([
            "user_id" => ["required", "exists:users,id"],
            "quiz_id" => ["required", "exists:quizzes,id"]
        ]);

        $oldGameSession = GameSession::query()->where($validated)->first();

        if ($oldGameSession) {
            return new GameSessionResouce($oldGameSession);
        }

        $validated["start_at"] = now();

        $gameSession = GameSession::query()->create($validated);

        return new GameSessionResouce($gameSession);
    }

    public function end_session(Request $request): GameSessionResouce
    {
        $validated = $request->validate([
            "game_session_id" => ["required", "exists:game_sessions,id"]
        ]);

        $gameSession = GameSession::find($validated["game_session_id"]);

        if (!$gameSession) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }

        if ($gameSession->user_id != $request->user()->id) {
            throw new HttpResponseException(response([
                "message" => "FORBIDDEN"
            ], 403));
        }

        $finished_at = now();

        $gameSession->update([
            "finished_at" => $finished_at
        ]);

        return new GameSessionResouce($gameSession);
    }

    public function get_session(Request $request, $id): GameSessionResouce
    {
        $gameSession = GameSession::query()->with([
            "quiz" => function ($query) {
                $query->with('questions', function ($query) {
                    $query->with('answers');
                });
            },
            "userAnswers" => function ($query) {
                $query->with('answer');
            }
        ])->find($id);

        if (!$gameSession) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }

        if ($gameSession->user_id != $request->user()->id) {
            throw new HttpResponseException(response([
                "message" => "FORBIDDEN"
            ], 403));
        }

        return new GameSessionResouce($gameSession);
    }

    public function get_user_answers($id): ResourceCollection
    {
        $gameSession = GameSession::query()->with("userAnswers", function ($query) {
            $query->with("answer");
        })->find($id);

        if (!$gameSession) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }

        return UserAnswerResouce::collection($gameSession->userAnswers);
    }
}
