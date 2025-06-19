<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\DashboardController;

// Default dashboard route
Route::get('/', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-only: Products
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('products', ProductController::class);
});

// Admin or Sales: Sales Orders
Route::middleware(['auth', 'role:admin,sales'])->group(function () {
    Route::get('/sales-orders', [SalesOrderController::class, 'index'])->name('sales-orders.index');
    Route::get('/sales-orders/create', [SalesOrderController::class, 'create'])->name('sales-orders.create');
    Route::post('/sales-orders', [SalesOrderController::class, 'store'])->name('sales-orders.store');
    Route::get('/sales-orders/{id}', [SalesOrderController::class, 'show'])->name('sales-orders.show');
    Route::get('/sales-orders/{id}/pdf', [SalesOrderController::class, 'downloadPDF'])->name('sales-orders.pdf');
});

// Auth scaffolding
require __DIR__.'/auth.php';
