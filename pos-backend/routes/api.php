<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// This one line creates all 5 routes: index, store, show, update, destroy
Route::apiResource('products', ProductController::class);