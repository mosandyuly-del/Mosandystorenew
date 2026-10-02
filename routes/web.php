<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/produk/{category?}', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/beli/{product}', [OrderController::class, 'create'])
    ->name('orders.create');

Route::post('/beli/{product}', [OrderController::class, 'store'])
    ->name('orders.store');

Route::get('/transaksi/{invoice}', [OrderController::class, 'show'])
    ->name('orders.show');

Route::get('/cek-transaksi', fn () => view('transactions.lookup'))
    ->name('orders.lookup');

Route::post('/cek-transaksi', [OrderController::class, 'lookup'])
    ->name('orders.lookup.post');

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard User
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::get('/products', [AdminController::class, 'products'])
            ->name('products');
    });
