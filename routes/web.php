<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;

// Default route
Route::get('/', function () {
    return view('auth/login');
});

// Authentication routes
Auth::routes();

// Home (protected)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');

// Role protected routes
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('role:admin');

Route::get('/shop', function () {
    return view('shop.index');
})->middleware('role:customer');

// User DataTable
Route::get('/admin/users/data', [App\Http\Controllers\Admin\UserController::class, 'getData'])
    ->name('admin.users.data');

// ✅ Products (admin only)
Route::middleware(['role:admin'])->group(function () {
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');
    Route::get('/products/trashed/data', [ProductController::class, 'getTrashedData'])->name('products.trashed.data');
    Route::post('/products/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::delete('/products/photos/{id}', [ProductController::class, 'deletePhoto'])->name('products.photos.delete');
});

// Categories
Route::resource('categories', CategoryController::class);

// Admin users
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/admin/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
});

// Customer account
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('account.update');

    Route::get('/account/change-password', [AccountController::class, 'changePasswordForm'])->name('account.password.form');
    Route::post('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password.update');

    Route::get('/account/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('account.orders');
});
