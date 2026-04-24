<?php

use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

$storePath = trim((string) config('peq.store_path', 'tienda'), '/');
$storePath = $storePath !== '' ? $storePath : 'tienda';

$adminPath = trim((string) config('peq.admin_path', 'panel-62f0f6d8c9b14e71a3'), '/');
$adminPath = $adminPath !== '' ? $adminPath : 'panel-62f0f6d8c9b14e71a3';

$legacyAdminPath = trim((string) config('peq.legacy_admin_path', 'peqcakes-panel-seguro-2026'), '/');

$adminLoginRedirect = static function () use ($adminPath) {
    $adminAppUrl = rtrim((string) config('peq.admin_app_url', ''), '/');

    if ($adminAppUrl === '') {
        abort(404);
    }

    return redirect()->away($adminAppUrl.'/'.$adminPath.'/login');
};

Route::get('/', [PublicController::class, 'index'])->name('home');
Route::view('/pronto', 'landing')->name('landing');
Route::get('/'.$storePath, [PublicController::class, 'index'])->name('store.home');
Route::get('/proximamente', function () {
    $html = '<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEQ Cakes · Próximamente</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --black: #0a0a0a;
            --white: #ffffff;
            --gray-100: #f5f5f5;
            --gray-300: #d4d4d4;
            --gray-500: #737373;
            --gray-700: #404040;
            --gray-900: #1a1a1a;
        }
        body {
            font-family: \'Manrope\', sans-serif;
            background: var(--white);
            color: var(--black);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        .logo-img {
            max-width: 350px;
            height: auto;
            margin-bottom: 2rem;
        }
        @media (max-width: 767px) {
            .logo-img {
                width: min(250px, 85vw);
            }
        }
        .tagline-texto {
            font-size: clamp(1rem, 2.5vw, 1.3rem);
            font-weight: 500;
            color: var(--gray-500);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }
        .divider {
            width: 40px;
            height: 2px;
            background: var(--gray-300);
            margin: 0 auto 2rem;
        }
        .coming-soon {
            font-size: clamp(2.5rem, 6vw, 3.5rem);
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--black);
        }
        .footer {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.7rem;
            color: var(--gray-500);
            letter-spacing: 0.1em;
        }
    </style>
</head>
<body>
    <img src="/img/logobn.jpg" alt="PEQ Cakes" class="logo-img">
    <div class="tagline-texto">Algo especial está en camino</div>
    <div class="divider"></div>
    <div class="coming-soon">Próximamente</div>
    <div class="footer">PEQ Cakes · 2026</div>
</body>
</html>';
    return response($html, 200, ['Content-Type' => 'text/html']);
})->name('landing.coming-soon');
Route::post('/order', [PublicController::class, 'storeOrder'])
    ->middleware('throttle:20,1')
    ->name('orders.store');
Route::post('/discounts/preview', [PublicController::class, 'previewDiscount'])
    ->middleware('throttle:40,1')
    ->name('discounts.preview');

Route::prefix('legal')->name('legal.')->group(function (): void {
    Route::view('/aviso-legal', 'legal.aviso-legal')->name('aviso-legal');
    Route::view('/privacidad', 'legal.privacidad')->name('privacidad');
    Route::view('/cookies', 'legal.cookies')->name('cookies');
    Route::view('/terminos-condiciones-compra', 'legal.terminos-condiciones-compra')->name('terminos-condiciones-compra');
});

// Socio routes (public, no auth required)
Route::get('/socio/registro', [MemberAuthController::class, 'showRegisterForm'])->name('member.register.form');
Route::post('/socio/registro', [MemberAuthController::class, 'register'])
    ->middleware('throttle:6,1')
    ->name('member.register');

Route::get('/socio/login', [MemberAuthController::class, 'showLoginForm'])->name('member.login');
Route::post('/socio/login', [MemberAuthController::class, 'login'])
    ->middleware('throttle:8,1')
    ->name('member.login.submit');

Route::get('/socio/olvide-password', [MemberAuthController::class, 'showForgotForm'])->name('member.forgot.form');
Route::post('/socio/olvide-password', [MemberAuthController::class, 'sendResetLink'])
    ->middleware('throttle:4,1')
    ->name('member.forgot');

Route::get('/socio/reset-password', [MemberAuthController::class, 'showResetForm'])->name('member.reset.form');
Route::post('/socio/reset-password', [MemberAuthController::class, 'resetPassword'])
    ->middleware('throttle:4,1')
    ->name('member.reset');

Route::post('/socio/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

Route::get('/'.$adminPath, $adminLoginRedirect)->name('admin.redirect');
Route::match(['GET', 'POST'], '/'.$adminPath.'/login', $adminLoginRedirect)->name('admin.login.redirect');

if ($legacyAdminPath !== '' && $legacyAdminPath !== $adminPath) {
    Route::get('/'.$legacyAdminPath, $adminLoginRedirect)->name('admin.legacy.redirect');
    Route::match(['GET', 'POST'], '/'.$legacyAdminPath.'/login', $adminLoginRedirect)->name('admin.legacy.login.redirect');
}

Route::match(['GET', 'POST'], '/login', function () {
    abort(404);
});
