<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\StockController;

Route::middleware('auth:api')->group(function () {
    // This one line creates all 5 routes: index, store, show, update, destroy
    Route::apiResource('products', ProductController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/suppliers',  [SupplierController::class, 'store']);

    Route::get('stock-movements',       [StockController::class, 'index']);
    Route::get('stock-movements/{stockMovement}', [StockController::class, 'show']);
    Route::post('stock-movements',      [StockController::class, 'store']);
});

Route::post('/login', [AuthController::class, 'login']);
