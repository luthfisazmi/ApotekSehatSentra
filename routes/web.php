<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;

// Route Produk
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

// Route Home setelah login (abis ada perubahan)
Route::get('/home', [LoginController::class, 'index'])->name('home')->middleware('auth');

Route::get('/home', [ProductController::class, 'index'])->name('home')->middleware('auth');

// Route Login User (Dashboard)
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});

// Route Resource untuk Products
Route::resource('products', ProductController::class);


// ================= TRANSAKSI ==================

// Menampilkan halaman daftar transaksi (admin)
Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');

// Tambah produk ke keranjang
Route::get('/add-to-cart/{id}', [TransactionController::class, 'addToCart'])->name('transactions.addToCart');

Route::post('/transactions/update-cart', [TransactionController::class, 'updateCart'])->name('transactions.updateCart');


// Hapus produk dari keranjang
Route::delete('/cart/remove/{id}', [TransactionController::class, 'removeFromCart'])->name('transactions.removeFromCart');

// Tampilkan halaman checkout (isi data + lihat isi keranjang)
Route::get('/checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');

// Proses checkout (form submit)
Route::post('/checkout', [TransactionController::class, 'processCheckout'])->name('transactions.processCheckout');

Route::get('/checkout-now/{id}', [TransactionController::class, 'checkoutNow'])->name('transactions.checkoutNow');

Route::post('/checkout/process', [TransactionController::class, 'processCheckout'])->name('transactions.processCheckout');

Route::get('/transaction-success/{transactionId}', [TransactionController::class, 'success'])->name('transactions.success');
Route::get('/transaction/{transactionId}/invoice-pdf', [TransactionController::class, 'generatePdfInvoice'])->name('transactions.invoicePdf');



Route::get('/transactions/history', [TransactionController::class, 'history'])->name('transactions.history');
Route::get('/transactions/history', [TransactionController::class, 'showHistory'])->name('transactions.history');
Route::get('/transactions/history', [TransactionController::class, 'showHistory'])->name('transactions.showHistory');



// Restore semua transaksi (opsional, admin)
Route::post('/transactions/restore-all', [TransactionController::class, 'restoreAll'])->name('transactions.restoreAll');


Route::get('/cart/cancel', function () {
    session()->forget('cart');
    return redirect('/dashboard')->with('info', 'Transaksi dibatalkan');
})->name('cart.cancel');


// Route Restore
Route::post('/products/restore-all', [ProductController::class, 'restoreAll'])->name('products.restoreAll');
Route::post('/transactions/restore-all', [TransactionController::class, 'restoreAll'])->name('transactions.restoreAll');
