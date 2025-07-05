<?php

use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test-broadcast', function () {
    broadcast(new \App\Events\TurnChanged(1, 'Test Player', 15, 280));
    return 'Broadcasted!';
});


Route::get('/laravel-websockets', function () {
    return view('websockets::dashboard');
});

Route::post('/game/create', [GameController::class, 'create']);
Route::post('/game/setup-players', [GameController::class, 'setupPlayers']);
Route::post('/game/turn', [GameController::class, 'startTurn']);
Route::get('/game/{code}', [GameController::class, 'getGameState']);
