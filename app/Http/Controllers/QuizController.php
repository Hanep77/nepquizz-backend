<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::query()->with(["user", "category", "difficulity", "questions"])->get();
        return QuizResource::collection($quizzes);
    }

    public function show(string $id): QuizResource
    {
        $quiz = Quiz::query()->with(["user", "category", "difficulity", "questions"])->find($id);
        if (!$quiz) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }
        return new QuizResource($quiz);
    }
}
