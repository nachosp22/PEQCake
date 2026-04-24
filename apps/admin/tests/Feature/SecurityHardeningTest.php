<?php

namespace Tests\Feature;

use App\Models\User;
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

    public function test_member_index_ignores_invalid_sort_and_direction_values(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('admin.members.index', [
            'sort' => 'id desc, (select sleep(5))',
            'dir' => 'sideways',
        ]));

        $response->assertOk();
    }

    public function test_admin_access_is_denied_for_non_whitelisted_email_when_list_is_configured(): void
    {
        config()->set('auth.admin_emails', ['owner@peqcakes.test']);

        $nonAdmin = User::factory()->create([
            'email' => 'staff@peqcakes.test',
        ]);

        $this->actingAs($nonAdmin)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_access_is_allowed_for_whitelisted_email(): void
    {
        config()->set('auth.admin_emails', ['owner@peqcakes.test']);

        $admin = User::factory()->create([
            'email' => 'owner@peqcakes.test',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_security_headers_are_included_in_web_responses(): void
    {
        $adminLoginPath = '/'.trim((string) config('peq.admin_path'), '/').'/login';

        $response = $this->get($adminLoginPath);

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }
}
