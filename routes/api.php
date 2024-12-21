<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductController;

Route::apiResource('products', ProductController::class);


// Route không yêu cầu xác thực
Route::post('/auth/login', [AuthController::class, 'login']);

// Route yêu cầu xác thực
Route::group(['middleware' => 'auth:api', 'prefix' => 'auth'], function () {
    Route::post('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/hello-world', function () {
        return response()->json(['message' => 'Hello, World!']);
    });
});
