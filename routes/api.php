<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AuthController;
Route::get('/ping', function () {
    return response()->json(['message' => 'API is working']);
});
//note: for every route in this file requires first api/ route
// CRUD routes
Route::get('/users', [UsersController::class, 'getAllUsers']);
Route::get('/users/{id}', [UsersController::class, 'getUserById']);
Route::post('/users', [UsersController::class, 'createUser']);
Route::put('/users/{id}', [UsersController::class, 'updateUser']);
Route::delete('/users/{id}', [UsersController::class, 'deleteUser']);


//API routes
//tese methods are open so we do not need to open a token 
Route::post("register",[AuthController::class,"register"]);
Route::post("login",[AuthController::class,"login"]);

Route::group([
    "middleware" =>["auth:api"] //it checks if the token is valid
],function(){
    Route::get("profile",[AuthController::class,"profile"]);
    Route::get("refresh",[AuthController::class,"refreshToken"]);
    Route::get("logout",[AuthController::class,"logout"]);

}) ;