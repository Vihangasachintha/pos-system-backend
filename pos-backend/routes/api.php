<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\VariantController;
use App\Http\Controllers\Api\SupplierController;

Route::middleware('auth:api')->group(function () {
    // This one line creates all 5 routes: index, store, show, update, destroy
    Route::apiResource('products', ProductController::class);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/brands', [BrandController::class, 'store']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/variants',   [VariantController::class,  'store']);
    Route::post('/suppliers',  [SupplierController::class, 'store']);
});

Route::post('/login', [AuthController::class, 'login']);