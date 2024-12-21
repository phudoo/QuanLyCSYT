<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;

Route::prefix('reports')->group(function () {
    Route::get('products', [ReportsController::class, 'getAllProductReports']);
    Route::get('products/{id}', [ReportsController::class, 'getProductReportById']);
    Route::get('orders', [ReportsController::class, 'getAllOrderReports']);
    Route::get('orders/{id}', [ReportsController::class, 'getOrderReportById']);
    Route::post('products', [ReportsController::class, 'createProductReport']);
    Route::post('orders', [ReportsController::class, 'createOrderReport']);
    Route::delete('products/{id}', [ReportsController::class, 'deleteProductReport']);
    Route::delete('orders/{id}', [ReportsController::class, 'deleteOrderReport']);
});

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
