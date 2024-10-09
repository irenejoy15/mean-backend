<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'posts']);
Route::post('/posts', [PostController::class, 'create_post']);
Route::delete('/posts/{id}', [PostController::class, 'delete']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
