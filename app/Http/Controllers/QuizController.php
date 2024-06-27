<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuizResource;
use App\Models\Quiz;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class QuizController extends Controller
{
    public function index(Request $request): ResourceCollection
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
        $quiz = Quiz::query()->with([
            "user", "category", "difficulity",
            "gameSession" => function ($query) use ($request) {
                $query->where("user_id", $request->user()->id);
            }, "questions" => function ($query) {
                $query->with(["answers"]);
            }
        ])->find($id);
        if (!$quiz) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }
        return new QuizResource($quiz);
    }

    public function store(Request $request): QuizResource | JsonResponse
    {
        $validated = $request->validate([
            "title" => ["required", "max:255"],
            "description" => ["required"],
            "category_id" => ["required", "exists:categories,id"],
            "difficulity_id" => ["required", "exists:difficulities,id"],
            "questions.*.content" => ["required", "max:255"],
            "questions.*.answers.*.content" => ["required", "max:100"],
            "questions.*.answers.*.is_correct" => ["required", "boolean"],
        ]);

        DB::beginTransaction();
        try {
            $quiz = Quiz::query()->create([
                "user_id" => $request->user()->id,
                "title" => $validated["title"],
                "description" => $validated["description"],
                "category_id" => $validated["category_id"],
                "difficulity_id" => $validated["difficulity_id"]
            ]);

            foreach ($validated["questions"] as $question) {
                $createdQuestion = $quiz->questions()->create([
                    "content" => $question["content"]
                ]);

                $createdQuestion->answers()->createMany($question['answers']);
            }

            DB::commit();
            return new QuizResource($quiz->load("questions.answers"));
        } catch (Exception $error) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create quiz', 'message' => $error->getMessage()], 500);
        }
    }

    public function destroy(string $id): JsonResponse {
        $quiz = Quiz::query()->find($id);

        if (!$quiz) {
            throw new HttpResponseException(response([
                "message" => "NOT FOUND"
            ], 404));
        }

        if ($quiz->delete()) {
            return response()->json(["message" => "deleted successfully"]);
        }
    }
}
