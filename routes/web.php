<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth/login');
});

// Register all authentication routes (login, register, logout, etc.)
Auth::routes();

// Protect the home route with authentication
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

// Products DataTable
Route::get('/products/data', [ProductController::class, 'getData'])->name('products.data');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');

    // New toggle route
    Route::patch('/admin/users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');

    // Manage products function
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('/products', App\Http\Controllers\ProductController::class);
    });
});


// For customer account
Route::middleware(['auth'])->group(function () {
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'edit'])->name('account.edit');
    Route::put('/account', [App\Http\Controllers\AccountController::class, 'update'])->name('account.update');

    Route::get('/account/change-password', [AccountController::class, 'changePasswordForm'])->name('account.password.form');
    Route::post('/account/change-password', [AccountController::class, 'changePassword'])->name('account.password.update');

    Route::get('/account/orders', [App\Http\Controllers\OrdersController::class, 'index'])->name('account.orders');
});

