<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $categoryParam = $request->input('category');
        $difficulityParam = $request->input('difficulity');
        $search = $request->input('search');
        $quizzes = Quiz::query()->with(["user", "category", "difficulity"]);

        if ($categoryParam) {
            $quizzes->whereHas('category', function ($query) use ($categoryParam) {
                $query->where('slug', $categoryParam);
            });
        }

        if ($difficulityParam) {
            $quizzes->whereHas('difficulity', function ($query) use ($difficulityParam) {
                $query->where('slug', $difficulityParam);
            });
        }

        if ($search) {
            $quizzes->where('title', 'LIKE', "%$search%");
        }

        return QuizResource::collection($quizzes->get());
    }

    public function show(Request $request, string $id): QuizResource
    {
        $quiz = Quiz::query()->with(["user", "category", "difficulity", "gameSession" => function ($query) use ($request) {
            $query->where("user_id", $request->user()->id);
        }, "questions" => function ($query) {
            $query->with(["answers"]);
        }])->find($id);
        if (!$quiz) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }
        return new QuizResource($quiz);
    }
}
