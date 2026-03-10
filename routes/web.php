<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

// Cart (AJAX)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/',           [CartController::class, 'get'])->name('get');
    Route::post('/add',       [CartController::class, 'add'])->name('add');
    Route::post('/remove',    [CartController::class, 'remove'])->name('remove');
    Route::post('/update',    [CartController::class, 'update'])->name('update');
    Route::post('/clear',     [CartController::class, 'clear'])->name('clear');
});

// Orders
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Admin (hidden URL)
Route::prefix('maria-admin')->name('admin.')->group(function () {
    Route::get('/',                       [AdminController::class, 'index'])->name('dashboard');
    Route::get('/orders/{order}',         [AdminController::class, 'show'])->name('show');
    Route::patch('/orders/{order}/status',[AdminController::class, 'updateStatus'])->name('updateStatus');
    Route::delete('/orders/{order}',      [AdminController::class, 'destroy'])->name('destroy');
});
