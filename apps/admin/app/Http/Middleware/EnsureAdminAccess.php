<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            abort(401);
        }

        $configuredEmails = array_values(array_filter(array_map(
            static fn (mixed $email): string => strtolower(trim((string) $email)),
            config('auth.admin_emails', [])
        )));

        if ($configuredEmails === []) {
            if (app()->environment('production')) {
                abort(403, 'Admin access list is not configured.');
            }

            return $next($request);
        }

        if (! in_array(strtolower((string) $user->email), $configuredEmails, true)) {
            abort(403);
        }

        return $next($request);
    }
}
