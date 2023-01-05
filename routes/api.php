<?php

use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\Account\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.bearer'])->group(function (){

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::get('/auth/isauth', [AuthController::class, 'isauth']);

});

Route::post('/auth/signin', [AuthController::class, 'signin']);
