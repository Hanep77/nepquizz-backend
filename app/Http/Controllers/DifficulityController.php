<?php

namespace App\Http\Controllers;

use App\Models\Difficulity;
use Illuminate\Http\Request;

class DifficulityController extends Controller
{
    public function index()
    {
        return Difficulity::query()->get();
    }
}
