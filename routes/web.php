<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication Routes (guest only)
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
    });

    // Authenticated admin routes
    Route::middleware('admin')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);

        // Products
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->except(['show']);
        Route::delete('products/{product}/images/{image}', [\App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])->name('products.images.destroy');
        Route::patch('products/{product}/images/{image}/primary', [\App\Http\Controllers\Admin\ProductController::class, 'setPrimary'])->name('products.images.primary');

        // Payment Methods
        Route::resource('payment-methods', \App\Http\Controllers\Admin\PaymentMethodController::class)->except(['show']);
        Route::patch('payment-methods/{payment_method}/toggle', [\App\Http\Controllers\Admin\PaymentMethodController::class, 'toggleActive'])->name('payment-methods.toggle');
    });
});

// Redirect /admin to /admin/dashboard
Route::redirect('/admin', '/admin/dashboard');
