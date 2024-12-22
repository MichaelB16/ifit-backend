<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



Route::prefix('v1')->group(function() {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/oauth/google', 'loginGoogle');
    });

    Route::post('add/personal', [UserController::class, 'store']);

    Route::prefix('new_password')->group(function () {
        Route::post('verify/{token}', [NewPasswordController::class, 'checkToken']);
        Route::put('update/{id}', [NewPasswordController::class, 'updatePassword']);
    });
});



Route::prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('students')->group(function () {
        Route::apiResource('', StudentController::class)->except(['create', 'edit']);
    });

    Route::prefix('user')->group(function () {
        Route::apiResource('', UserController::class)->except(['create', 'edit']);
    });

    Route::prefix('dashboard')->group(function() {
        Route::get('summary', [DashboardController::class, 'summary']);
    });

})->middleware('auth:sanctum');

