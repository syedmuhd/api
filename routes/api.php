<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterStaffController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {

    // Login for Admin, Staff, Parent, Student
    Route::post('login', LoginController::class);

    // Registration
    Route::prefix('register')->group(function () {
        Route::middleware(['auth:sanctum', 'ability:register-user'])->group(function () {
            Route::post('staff', RegisterStaffController::class);
            Route::post('parent', RegisterStaffController::class);
            Route::post('student', RegisterStaffController::class);
        });
    });
});
