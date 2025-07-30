<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});

// CRUD routes
Route::get('/users', [UsersController::class, 'getAllUsers']);
Route::get('/users/{id}', [UsersController::class, 'getUserById']);
Route::post('/users', [UsersController::class, 'createUser']);
Route::put('/users/{id}', [UsersController::class, 'updateUser']);
Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);
