<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Member;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyMember
{
    private const MEMBER_COOKIE_NAME = 'member_token';

    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie(self::MEMBER_COOKIE_NAME);
        $shouldForgetCookie = false;

        if ($token !== null && $token !== '') {
            $member = Member::where('login_token', $token)
                ->where('token_expires_at', '>', now())
                ->first();

            if ($member) {
                $request->attributes->set('member', $member);
            } else {
                $shouldForgetCookie = true;
            }
        }

        $response = $next($request);

        if ($shouldForgetCookie) {
            $response->headers->setCookie(cookie()->forget(
                self::MEMBER_COOKIE_NAME,
                (string) config('session.path', '/'),
                config('session.domain')
            ));
        }

        return $response;
    }
}
