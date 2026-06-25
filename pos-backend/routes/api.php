<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SaleController;

Route::middleware('auth:api')->group(function () {
    // This one line creates all 5 routes: index, store, show, update, destroy
    Route::apiResource('products', ProductController::class);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/brands', [BrandController::class, 'store']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::post('/suppliers',  [SupplierController::class, 'store']);
    Route::get('/suppliers/{supplier}',  [SupplierController::class, 'show']);
    Route::get('/suppliers',  [SupplierController::class, 'index']);

    Route::get('stock-movements',       [StockController::class, 'index']);
    Route::get('stock-movements/{stockMovement}', [StockController::class, 'show']);
    Route::post('stock-movements',      [StockController::class, 'store']);

    Route::get('expenses',              [ExpenseController::class, 'index']);
    Route::get('expenses/{expense}',    [ExpenseController::class, 'show']);
    Route::post('expenses',             [ExpenseController::class, 'store']);
    Route::put('expenses/{expense}',    [ExpenseController::class, 'update']);
    Route::delete('expenses/{expense}', [ExpenseController::class, 'destroy']);

    Route::get('sales',          [SaleController::class, 'index']);
    Route::get('sales/{sale}',   [SaleController::class, 'show']);
    Route::post('sales',         [SaleController::class, 'store']);
});

Route::post('/login', [AuthController::class, 'login']);
