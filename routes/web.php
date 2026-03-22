<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ReviewController;

// Default route → login page
Route::get('/', function () {
    return view('auth.login');
});

// Authentication routes (login, register, email verification, etc.)
Auth::routes(['verify' => true]);

// Home (only for authenticated + verified users)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware(['auth', 'verified']);

// ===============================
// Admin Routes (auth + verified + role:admin)
// ===============================
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Admin dashboard
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Products management
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');
    Route::get('/products/trashed/data', [ProductController::class, 'getTrashedData'])->name('products.trashed.data');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::delete('/products/photos/{id}', [App\Http\Controllers\ProductController::class, 'deletePhoto'])
    ->name('products.photos.delete');



    // Categories management
    Route::resource('categories', CategoryController::class);

    // Admin users management
    Route::get('/admin/users/data', [UserController::class, 'getData'])->name('admin.users.data');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
});

// ===============================
// Customer Routes (auth + verified + role:customer)
// ===============================
Route::middleware(['auth', 'verified'])->group(function () {
    // Shop
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');

    // Account management
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/account/change-password', [AccountController::class, 'changePasswordForm'])->name('account.password.form');
    Route::post('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password.update');

    // Orders
    Route::get('/account/orders', [OrdersController::class, 'index'])->name('account.orders');

    // Cart
    Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    // Add product to cart (POST)
    Route::post('/cart/add/{product}', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    // Update quantity (PUT)
    Route::put('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    // Remove product (DELETE)
    Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    // Clear cart (DELETE)
    Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');


    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Reviews
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('products.review');
});
