<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login2']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    //user

    Route::post('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //post

    Route::get('/post/{id}', [PostController::class, 'index']);
    Route::post('/post/{id}', [PostController::class, 'store']);

    Route::get('/post/{id}', [PostController::class, 'show']);

    Route::put('/post/{id}', [PostController::class, 'update']);
    Route::delete('/post/{id}', [PostController::class, 'destroy']);




    //Comment

    Route::get('/post/{id}/comments', [CommentController::class, 'index']);
    Route::post('/post/{id}/comments', [CommentController::class, 'store']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});






//like 

Route::post('/posts/{id}/like', [LikeController::class, 'likeOrUnlike']);



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
