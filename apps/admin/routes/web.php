<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\CakeController;
use App\Http\Controllers\Admin\BlockedDayController;
use App\Http\Controllers\Admin\BlockedWeekdayController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

$adminPath = trim((string) config('peq.admin_path', 'panel-62f0f6d8c9b14e71a3'), '/');
$adminPath = $adminPath !== '' ? $adminPath : 'panel-62f0f6d8c9b14e71a3';

$legacyAdminPath = trim((string) config('peq.legacy_admin_path', 'peqcakes-panel-seguro-2026'), '/');

Route::prefix($adminPath)->middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.perform');
});

Route::match(['GET', 'POST'], '/login', function () {
    abort(404);
});

Route::middleware('auth')->group(function () use ($adminPath, $legacyAdminPath): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    if ($legacyAdminPath !== '' && $legacyAdminPath !== $adminPath) {
        Route::get('/'.$legacyAdminPath, function () {
            return redirect()->route('admin.dashboard');
        })->middleware('admin.access')->name('admin.legacy.redirect');
    }

    Route::prefix($adminPath)->middleware('admin.access')->name('admin.')->group(function (): void {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::patch('/orders/{order}/complete', [AdminController::class, 'complete'])->name('orders.complete');
        Route::patch('/orders/{order}/confirm', [AdminController::class, 'confirm'])->name('orders.confirm');
        Route::patch('/orders/{order}/pay', [AdminController::class, 'pay'])->name('orders.pay');

        Route::resource('cakes', CakeController::class)->except(['create', 'show', 'edit']);
        Route::patch('cakes/{cake}/restore', [CakeController::class, 'restore'])->withTrashed()->name('cakes.restore');

        Route::resource('discounts', DiscountController::class)->except(['create', 'show', 'edit']);
        Route::patch('discounts/{discount}/toggle-active', [DiscountController::class, 'toggleActive'])->name('discounts.toggle-active');

        Route::get('agenda', [AgendaController::class, 'index'])->name('agenda.index');
        Route::put('agenda/lead-time', [AgendaController::class, 'updateLeadTime'])->name('agenda.lead-time.update');
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::post('reports/export-orders', [ReportController::class, 'exportOrders'])->name('reports.export-orders');
        Route::put('agenda/blocked-weekdays', [BlockedWeekdayController::class, 'update'])->name('blocked-weekdays.update');

        Route::post('blocked-days', [BlockedDayController::class, 'store'])->name('blocked-days.store');
        Route::delete('blocked-days/{blockedDay}', [BlockedDayController::class, 'destroy'])->name('blocked-days.destroy');

        Route::get('blocked-days', function () {
            return redirect()->route('admin.agenda.index');
        })->name('blocked-days.index');

        Route::resource('members', MemberController::class)->except(['create', 'show', 'store']);
    });
});
