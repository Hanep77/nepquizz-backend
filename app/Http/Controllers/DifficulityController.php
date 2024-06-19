<?php

namespace App\Http\Controllers;

use App\Models\Difficulity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DifficulityController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Difficulity::query()->get());
    }
}
