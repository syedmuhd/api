<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication routes
 */
Route::prefix('auth')->group(function () {
    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
});
