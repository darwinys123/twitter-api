<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\TweetController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/tweets', [TweetController::class, 'index']);
    Route::group(['prefix' => 'tweet'], function () {
        Route::post('/', [TweetController::class, 'store']);
        Route::put('/{id}', [TweetController::class, 'update']);
        Route::delete('/{id}', [TweetController::class, 'delete']);
    });
    Route::get('/followers', [FollowerController::class, 'index']);
    Route::group(['prefix' => 'follow'], function () {
        Route::post('/{id}', [FollowerController::class, 'follow']);
        Route::delete('/{id}', [FollowerController::class, 'unfollow']);
    });
});
