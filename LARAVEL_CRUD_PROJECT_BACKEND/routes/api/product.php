<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'index']);  // List all products
Route::get('products/{id}', [ProductController::class, 'show']);  // Show a specific product
Route::post('products', [ProductController::class, 'store']);  // Create a new product
Route::delete('products/{id}', [ProductController::class, 'destroy']);  // Delete a product
