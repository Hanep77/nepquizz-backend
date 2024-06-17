<?php

use App\Http\Controllers\UserAnswerController;
use Illuminate\Support\Facades\Route;

Route::post('/user-answer', [UserAnswerController::class, 'store']);
