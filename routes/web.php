<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomepageController::class, 'index'])->name('home');

Route::get('products', [HomepageController::class, 'products']);
Route::get('product/{slug}', [HomepageController::class, 'product'])->name('product.show');
Route::get('categories', [HomepageController::class, 'categories']);
Route::get('category/{slug}', [HomepageController::class, 'category']);

Route::get('cart', [HomepageController::class, 'cart'])->name('cart.index');

Route::view('/contact', 'theme.default.contact')->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/checkout', [HomepageController::class, 'checkout'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success', function () {
    return view('theme.default.checkout_success');
})->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Cart Routes (hanya jika customer login)
|--------------------------------------------------------------------------
*/
Route::middleware(['is_customer_login'])->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::post('cart/add', 'add')->name('cart.add');
        Route::delete('cart/remove/{id}', 'remove')->name('cart.remove');
        Route::patch('cart/update/{id}', 'update')->name('cart.update');
    });
});

/*
|--------------------------------------------------------------------------
| Customer Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->group(function () {
    Route::controller(CustomerAuthController::class)->group(function () {
        Route::middleware(['check_customer_login'])->group(function () {
            Route::get('login', 'login')->name('customer.login');
            Route::post('login', 'store_login')->name('customer.store_login');
            Route::get('register', 'register')->name('customer.register');
            Route::post('register', 'store_register')->name('customer.store_register');
        });

        Route::post('logout', 'logout')->name('customer.logout');
    });
});

/*
|--------------------------------------------------------------------------
| Dashboard (admin)
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', ProductCategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('themes', ThemeController::class);
    Route::patch('products/{id}/toggle', [ProductController::class, 'toggle'])->name('products.toggle');
    Route::post('products/sync/{id}', [ProductController::class, 'sync'])->name('products.sync');
    Route::post('category/sync/{id}', [ProductCategoryController::class, 'sync'])->name('category.sync');
});

/*
|--------------------------------------------------------------------------
| Settings Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__ . '/auth.php';
