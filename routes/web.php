<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
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

// Home (shop page with filters)
Route::get('/home', [App\Http\Controllers\ProductController::class, 'index'])
    ->name('shop.index')
    ->middleware(['auth', 'verified']);

// --------------------
// ADMIN ROUTES
// --------------------
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Products management
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    Route::get('/products/data', [ProductController::class, 'getData'])->name('admin.products.data');
    Route::get('/products/trashed/data', [ProductController::class, 'getTrashedData'])->name('admin.products.trashed.data');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('admin.products.restore');
    Route::post('/products/import', [ProductController::class, 'import'])->name('admin.products.import');
    Route::delete('/products/photos/{id}', [ProductController::class, 'deletePhoto'])->name('admin.products.photos.delete');
    Route::delete('/products/{id}/force', [ProductController::class, 'forceDestroy'])->name('admin.products.forceDestroy');

    // Categories management
    Route::resource('categories', CategoryController::class)->names([
        'index'   => 'admin.categories.index',
        'create'  => 'admin.categories.create',
        'store'   => 'admin.categories.store',
        'show'    => 'admin.categories.show',
        'edit'    => 'admin.categories.edit',
        'update'  => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Users management
    Route::get('/users/data', [UserController::class, 'getData'])->name('admin.users.data');
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');

    // Orders management (Admin)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::get('/orders/{order}/edit', [AdminOrderController::class, 'edit'])->name('admin.orders.edit');
    Route::put('/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Admin review listing
    Route::get('/reviews/data', [ReviewController::class, 'getData'])->name('admin.reviews.data');
    Route::get('/reviews', function () {
        return view('admin.reviews.index');
    })->name('admin.reviews.index');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Reports / Analytics
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('admin.reports.index');
});

// --------------------
// CUSTOMER ROUTES
// --------------------
Route::middleware(['auth', 'verified'])->group(function () {
    // Shop
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/products/{product}', [ShopController::class, 'show'])->name('products.show');

    // Account management
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/account/change-password', [AccountController::class, 'changePasswordForm'])->name('account.password.form');
    Route::post('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password.update');

    // Orders (Customer)
    Route::get('/account/orders', [OrdersController::class, 'index'])->name('account.orders');

    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update-all', [CartController::class, 'updateAll'])->name('cart.updateAll');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Reviews (Customer)
    Route::get('/products/{product}/review', [ReviewController::class, 'form'])->name('products.review.form');
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('products.review');

    // Consistent naming for edit/update
    Route::get('/account/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('account.reviews.edit');
    Route::put('/account/reviews/{review}', [ReviewController::class, 'update'])->name('account.reviews.update');

    Route::get('/account/reviews', [ReviewController::class, 'myReviews'])->name('account.reviews');
});
