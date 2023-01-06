<?php

use App\Http\Controllers\Account\AuthController;
use App\Http\Controllers\Account\UserController;
use App\Http\Controllers\Ad\CategoryController;
use App\Http\Controllers\Partner\PartnerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.bearer'])->group(function (){

    // ACCOUNT
    Route::get('/auth/isauth', [AuthController::class, 'isauth']);

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // PARTNER
    Route::get('/partner', [PartnerController::class, 'index']);
    Route::get('/partner/{id}', [PartnerController::class, 'show']);
    Route::post('/partner', [PartnerController::class, 'store']);
    Route::put('/partner/{id}', [PartnerController::class, 'update']);
    Route::delete('/partner/{id}', [PartnerController::class, 'destroy']);

    // AD
    Route::get('/ad/category', [CategoryController::class, 'index']);
    Route::get('/ad/category/{id}', [CategoryController::class, 'show']);
    Route::post('/ad/category', [CategoryController::class, 'store']);
    Route::put('/ad/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/ad/category/{id}', [CategoryController::class, 'destroy']);
    
});

Route::post('/auth/signin', [AuthController::class, 'signin']);
