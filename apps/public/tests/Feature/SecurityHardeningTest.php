<?php

namespace Tests\Feature;

use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(ValidateCsrfToken::class);
    }

    public function test_security_headers_are_included_in_web_responses(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }

    public function test_member_login_is_rate_limited_after_repeated_attempts(): void
    {
        for ($attempt = 0; $attempt < 8; $attempt++) {
            $this->post(route('member.login.submit'), [
                'identifier' => 'missing@peqcakes.test',
                'password' => 'invalid-password',
            ]);
        }

        $this->post(route('member.login.submit'), [
            'identifier' => 'missing@peqcakes.test',
            'password' => 'invalid-password',
        ])->assertStatus(429);
    }
}
