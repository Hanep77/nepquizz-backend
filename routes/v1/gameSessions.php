<?php

use App\Http\Controllers\GameSessionController;
use Illuminate\Support\Facades\Route;

Route::post('/start-game', [GameSessionController::class, 'start_session']);
Route::post('/end-game', [GameSessionController::class, 'end_session']);
Route::get('/get-game/{id}', [GameSessionController::class, 'get_session']);
Route::get('/get-user-answers/{id}', [GameSessionController::class, 'get_user_answers']);
