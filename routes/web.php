<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
Route::get('/product/{productName}', [ProductController::class, 'show'])->name('product.show');
Route::get('/checkout/{productName}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{productName}', [CheckoutController::class, 'confirm'])->name('checkout.confirm');



