<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\LoginController;


Route::get('/products', [ProductController::class, 'index'])->name('home'); 
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); 
Route::post('/products', [ProductController::class, 'store'])->name('products.store'); 
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); 
Route::get('/products/{products}/edit', [ProductController::class, 'edit'])->name('products.edit'); 
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

// Route Login
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/home', [ProductController::class, 'index'])->name('home')->middleware('auth');

// Route Login User (Dashboard)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 



// Route Resource - Mencakup semua route products
Route::resource('products', ProductController::class);

// Route untuk halaman utama
Route::get('/', [ProductController::class, 'home'])->name('home');

// Route transaksi
Route::resource('transactions', TransactionController::class);
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

// Route restore
Route::post('/products/restore-all', [ProductController::class, 'restoreAll'])->name('products.restoreAll');
Route::post('/transactions/restore-all', [TransactionController::class, 'restoreAll'])->name('transactions.restoreAll');