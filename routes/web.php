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

        // Orders
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/approve', [\App\Http\Controllers\Admin\OrderController::class, 'approvePayment'])->name('orders.approve');
        Route::patch('orders/{order}/reject', [\App\Http\Controllers\Admin\OrderController::class, 'rejectPayment'])->name('orders.reject');
        Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('orders/{order}/proof', [\App\Http\Controllers\Admin\OrderController::class, 'downloadProof'])->name('orders.download-proof');

        // Settings
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // FAQs
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class)->except(['show']);

        // Pages
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class)->only(['edit', 'update']);

        // Contact Messages
        Route::get('contact-messages', [\App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{contact_message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('contact-messages/{contact_message}/toggle', [\App\Http\Controllers\Admin\ContactMessageController::class, 'toggleStatus'])->name('contact-messages.toggle');
        Route::delete('contact-messages/{contact_message}', [\App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Admins
        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class)->except(['show']);
        Route::get('admins/{admin}/password', [\App\Http\Controllers\Admin\AdminController::class, 'editPassword'])->name('admins.password');
        Route::patch('admins/{admin}/password', [\App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])->name('admins.password.update');

        // Testimonials
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except(['show']);

        // Media Manager
        Route::get('media', [\App\Http\Controllers\Admin\MediaController::class, 'index'])->name('media.index');
        Route::post('media', [\App\Http\Controllers\Admin\MediaController::class, 'store'])->name('media.store');
        Route::delete('media/{media}', [\App\Http\Controllers\Admin\MediaController::class, 'destroy'])->name('media.destroy');
    });
});

// Redirect /admin to /admin/dashboard
Route::redirect('/admin', '/admin/dashboard');

/*
|--------------------------------------------------------------------------
| Storefront Routes
|--------------------------------------------------------------------------
*/

// Shop & Products
Route::get('/', [\App\Http\Controllers\Storefront\ShopController::class, 'index'])->name('home');
Route::get('/products/{slug}', [\App\Http\Controllers\Storefront\ProductController::class, 'show'])->name('products.show');

// Cart
Route::get('/cart', [\App\Http\Controllers\Storefront\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\Storefront\CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update', [\App\Http\Controllers\Storefront\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove', [\App\Http\Controllers\Storefront\CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [\App\Http\Controllers\Storefront\CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [\App\Http\Controllers\Storefront\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [\App\Http\Controllers\Storefront\CheckoutController::class, 'store'])->name('checkout.store');

// Order Tracking
Route::get('/order-tracking', [\App\Http\Controllers\Storefront\TrackingController::class, 'index'])->name('tracking.index');
Route::post('/order-tracking', [\App\Http\Controllers\Storefront\TrackingController::class, 'search'])->name('tracking.search');
Route::get('/order-tracking/{order_number}', [\App\Http\Controllers\Storefront\TrackingController::class, 'show'])->name('tracking.show');

// Public Pages
Route::get('/faq', [\App\Http\Controllers\Storefront\PageController::class, 'faq'])->name('faq');
Route::get('/contact', [\App\Http\Controllers\Storefront\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [\App\Http\Controllers\Storefront\ContactController::class, 'store'])->name('contact.store');

// Catch-all for dynamic pages (Must be at the bottom of standard pages)
Route::post('/testimonials', [\App\Http\Controllers\Storefront\PageController::class, 'storeTestimonial'])->name('testimonials.store');
Route::get('/pages/{slug}', [\App\Http\Controllers\Storefront\PageController::class, 'show'])->name('page.show');
