<?php

use App\Http\Controllers\Account\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'index']);