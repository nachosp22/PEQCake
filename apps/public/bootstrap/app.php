<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\IdentifyMember::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => $e->getMessage() ?: 'Ha fallado algo'], $e->getStatusCode());
            }
            $status = $e->getStatusCode();
            if ($status === 503) {
                return response()->view('errors.503', ['exception' => $e], 503);
            }
            if ($status >= 500) {
                return response()->view('errors.5xx', ['exception' => $e], $status);
            }
            return response()->view('errors.4xx', ['exception' => $e], $status);
        });
    })->create();
