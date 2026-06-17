<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


// Route::middleware('auth-api')->group(function () {

// });

// This one line creates all 5 routes: index, store, show, update, destroy
Route::apiResource('products', ProductController::class);
Route::post('/login', [AuthController::class, 'login']);