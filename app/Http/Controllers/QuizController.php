<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::query()->with(["user", "category", "difficulity"])->get();
        return QuizResource::collection($quizzes);
    }
}
