<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::prefix('users')->group(function () {
    Route::post('/', [\App\Http\Controllers\UserController::class, 'store']);
    Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/{user}', [\App\Http\Controllers\UserController::class, 'show']);
    Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update']);
    Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy']);
});

Route::get('/user-statistics', [UserController::class, 'getUserStatistics']);
