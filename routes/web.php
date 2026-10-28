<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyOrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RickrollController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/rickroll', [RickrollController::class, 'redirect'])->name('rickroll');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist/{productId}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/myorder', [MyOrderController::class, 'index'])->name('myorder');
    Route::get('/checkout/{productName}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout/{productName}', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
});

Route::get('/product/{productName}', [ProductController::class, 'show'])->name('product.show');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
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

    Route::get('/rickroll', [AdminController::class, 'rickroll'])->name('rickroll');
});




