<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::post('/order', [PublicController::class, 'storeOrder'])->name('orders.store');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::patch('/admin/orders/{order}/complete', [AdminController::class, 'complete'])->name('admin.orders.complete');
});
