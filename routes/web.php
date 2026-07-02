<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Shop;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Storefront (หน้าบ้าน) — customer facing
|--------------------------------------------------------------------------
*/
Route::get('/', [Shop\HomeController::class, 'index'])->name('shop.home');
Route::get('/category/{serviceCategory}', [Shop\CatalogController::class, 'category'])->name('shop.category');
Route::get('/product/{product}', [Shop\CatalogController::class, 'product'])->name('shop.product');

// Customer authentication (web guard)
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [Customer\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [Customer\AuthController::class, 'login']);
    Route::get('/register', [Customer\AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [Customer\AuthController::class, 'register']);
});

Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [Customer\AuthController::class, 'logout'])->name('logout');

    Route::get('/account', [Customer\AccountController::class, 'dashboard'])->name('account.dashboard');

    Route::get('/account/wallet', [Customer\WalletController::class, 'index'])->name('account.wallet');
    Route::post('/account/wallet/topup', [Customer\WalletController::class, 'topup'])->name('account.wallet.topup');

    Route::get('/account/orders', [Customer\OrderController::class, 'index'])->name('account.orders');
    Route::get('/account/orders/{purchase}', [Customer\OrderController::class, 'show'])->name('account.orders.show');

    Route::post('/product/{product}/buy', [Customer\PurchaseController::class, 'store'])->name('purchase.store');
});

/*
|--------------------------------------------------------------------------
| Admin backend (หลังบ้าน) — /admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });

    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('categories', Admin\ServiceCategoryController::class)->except(['show']);
        Route::resource('products', Admin\ProductController::class)->except(['show']);

        Route::get('/products/{product}/stock', [Admin\StockController::class, 'index'])->name('products.stock');
        Route::post('/products/{product}/stock', [Admin\StockController::class, 'store'])->name('products.stock.store');
        Route::delete('/products/{product}/stock/{stockItem}', [Admin\StockController::class, 'destroy'])->name('products.stock.destroy');

        Route::get('/orders', [Admin\PurchaseController::class, 'index'])->name('orders.index');
        Route::get('/orders/{purchase}', [Admin\PurchaseController::class, 'show'])->name('orders.show');

        Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
        Route::post('/users/{user}/balance', [Admin\UserController::class, 'adjustBalance'])->name('users.balance');

        Route::get('/wallet', [Admin\WalletController::class, 'index'])->name('wallet.index');
    });
});
