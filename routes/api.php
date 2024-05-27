<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterParentController;
use App\Http\Controllers\Auth\RegisterStaffController;
use App\Http\Controllers\Auth\RegisterStudentController;
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
        // Only Admin can register staff
        Route::middleware(['auth:sanctum', 'ability:Admin'])->group(function () {
            Route::post('staff', RegisterStaffController::class);
        });

        // Only Admin|Staff can register parent and/or student
        Route::middleware(['auth:sanctum', 'ability:Admin,Staff'])->group(function () {
            Route::post('parent', RegisterParentController::class);
        });

        // Only Admin|Staff|Parent can register parent and/or student
        Route::middleware(['auth:sanctum', 'ability:Admin,Staff,Parent'])->group(function () {
            Route::post('student', RegisterStudentController::class);
        });
    });
});
