<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/posts', [PostController::class, 'posts']);
Route::get('/posts/search', [PostController::class, 'posts_search']);
Route::post('/posts', [PostController::class, 'create_post']);
Route::get('/posts/{id}', [PostController::class, 'edit']);
Route::post('/posts/{id}', [PostController::class, 'update']);
Route::get('/posts/edittest/{id}', [PostController::class, 'edittest']);
Route::delete('/posts/{id}', [PostController::class, 'delete']);

Route::get('/signup', [UserController::class, 'signup']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
