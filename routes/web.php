<?php

use App\Http\Controllers\AdminController;
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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/order', [AdminController::class, 'order'])->name('order');

    Route::get('/product', [AdminController::class, 'product'])->name('product');
    Route::get('/add-product', [AdminController::class, 'createProduct'])->name('product.create');
    Route::post('/add-product', [AdminController::class, 'storeProduct'])->name('product.store');
    Route::get('/edit-{productName}', [AdminController::class, 'editProduct'])->name('product.edit');
    Route::put('/edit-{productName}', [AdminController::class, 'updateProduct'])->name('product.update');
    Route::delete('/product/{productName}', [AdminController::class, 'destroyProduct'])->name('product.destroy');

    Route::get('/account', [AdminController::class, 'account'])->name('account');
    Route::get('/add-user', [AdminController::class, 'createUser'])->name('account.create');
    Route::post('/add-user', [AdminController::class, 'storeUser'])->name('account.store');
    Route::patch('/account/{id}/role', [AdminController::class, 'updateUserRole'])->name('account.update');
    Route::delete('/account/{id}', [AdminController::class, 'destroyUser'])->name('account.delete');
});




