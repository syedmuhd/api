<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/**
 * Authentication routes
 */
Route::prefix('auth')->group(function () {
    Route::post('login', LoginController::class);
    Route::post('register', RegisterController::class);
});
