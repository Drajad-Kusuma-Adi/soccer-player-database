<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlayerController;
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

Route::post('/users/auth', [UserController::class, 'login']);
Route::post('/users/logout', [UserController::class, 'logout']);

Route::post('/users', [UserController::class, 'register']);
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/users/{id}', [UserController::class, 'getUserById']);
Route::put('/users/{id}', [UserController::class, 'modifyUserById']);
Route::delete('/users/{id}', [UserController::class, 'deleteUserById']);

Route::post('/players', [PlayerController::class, 'registerPlayer']);
Route::get('/players', [PlayerController::class, 'getAllPlayers']);
Route::get('/players/{id}', [PlayerController::class, 'getPlayerById']);
Route::put('/players/{id}', [PlayerController::class, 'modifyPlayerById']);
Route::delete('/players/{id}', [PlayerController::class, 'deletePlayerById']);