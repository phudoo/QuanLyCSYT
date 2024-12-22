<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\OrderController;

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

// Routes cho Order (CRUD)
Route::group(['prefix' => 'orders', 'middleware' => 'auth:api'], function () {
    Route::get('/', [OrderController::class, 'index']); // Lấy danh sách đơn hàng
    Route::get('/{id}', [OrderController::class, 'show']); // Lấy chi tiết đơn hàng
    Route::post('/', [OrderController::class, 'store']); // Tạo mới đơn hàng
    Route::put('/{id}', [OrderController::class, 'update']); // Cập nhật trạng thái đơn hàng
    Route::delete('/{id}', [OrderController::class, 'destroy']); // Xóa đơn hàng
});

Route::group(['prefix' => 'order_items', 'middleware' => 'auth:api'], function () {
    Route::get('/', [OrderItemController::class, 'index']); // Lấy danh sách tất cả mặt hàng
    Route::get('/{id}', [OrderItemController::class, 'show']); // Lấy thông tin chi tiết mặt hàng
    Route::post('/', [OrderItemController::class, 'store']); // Tạo mặt hàng mới
    Route::put('/{id}', [OrderItemController::class, 'update']); // Cập nhật mặt hàng
    Route::delete('/{id}', [OrderItemController::class, 'destroy']); // Xóa mặt hàng
});

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
