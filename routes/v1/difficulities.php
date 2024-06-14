<?php

use App\Http\Controllers\DifficulityController;
use Illuminate\Support\Facades\Route;

Route::get('/difficulities', [DifficulityController::class, 'index']);
Route::get('/difficulities/{id}', [DifficulityController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/difficulities', [DifficulityController::class, 'store']);
    Route::post('/difficulities/{id}', [DifficulityController::class, 'update']);
    Route::delete('/difficulities/{id}', [DifficulityController::class, 'delete']);
});
