<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthBoundaryParityTest extends TestCase
{
    use RefreshDatabase;

    public function test_whitelisted_admin_can_log_in_from_admin_login_path(): void
    {
        config()->set('auth.admin_emails', ['owner@peqcakes.test']);

        $admin = User::factory()->create([
            'email' => 'owner@peqcakes.test',
            'password' => Hash::make('secret-pass'),
        ]);

        $response = $this->from($this->adminLoginPath())
            ->post(route('login.perform'), [
                'email' => 'owner@peqcakes.test',
                'password' => 'secret-pass',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_non_whitelisted_user_cannot_establish_admin_session_even_with_valid_password(): void
    {
        config()->set('auth.admin_emails', ['owner@peqcakes.test']);

        User::factory()->create([
            'email' => 'staff@peqcakes.test',
            'password' => Hash::make('secret-pass'),
        ]);

        $response = $this->from($this->adminLoginPath())
            ->post(route('login.perform'), [
                'email' => 'staff@peqcakes.test',
                'password' => 'secret-pass',
            ]);

        $response->assertRedirect($this->adminLoginPath());
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_allowlist_comparison_is_case_insensitive_during_login(): void
    {
        config()->set('auth.admin_emails', ['OWNER@PEQCAKES.TEST']);

        $admin = User::factory()->create([
            'email' => 'owner@peqcakes.test',
            'password' => Hash::make('secret-pass'),
        ]);

        $response = $this->from($this->adminLoginPath())
            ->post(route('login.perform'), [
                'email' => 'owner@peqcakes.test',
                'password' => 'secret-pass',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_public_session_cookie_does_not_grant_admin_access(): void
    {
        $response = $this->withCookie('peq_public_session', 'public-session-token')
            ->get(route('admin.dashboard'));

        $response->assertRedirect($this->adminLoginPath());
        $this->assertGuest();
    }

    private function adminLoginPath(): string
    {
        return '/'.trim((string) config('peq.admin_path'), '/').'/login';
    }
}
