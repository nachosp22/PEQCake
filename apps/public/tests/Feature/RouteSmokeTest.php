<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_shows_storefront(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('PIDE LA TUYA')
            ->assertSee('href="#productos"', false)
            ->assertSee('href="#tienda"', false)
            ->assertSee('href="#pedido"', false)
            ->assertSee('id="productos"', false)
            ->assertSee('id="tienda"', false)
            ->assertSee('id="pedido"', false);
    }

    public function test_storefront_route_is_available(): void
    {
        $this->get(route('store.home'))
            ->assertOk();
    }

    public function test_admin_configured_path_redirects_to_admin_app_login(): void
    {
        config()->set('peq.admin_app_url', 'https://admin.peq.test');

        $adminPath = trim((string) config('peq.admin_path'), '/');

        $this->get('/'.$adminPath)
            ->assertRedirect('https://admin.peq.test/'.$adminPath.'/login');
    }

    public function test_admin_login_path_redirects_to_admin_app_login(): void
    {
        config()->set('peq.admin_app_url', 'https://admin.peq.test/');

        $adminPath = trim((string) config('peq.admin_path'), '/');

        $this->get('/'.$adminPath.'/login')
            ->assertRedirect('https://admin.peq.test/'.$adminPath.'/login');
    }

    public function test_legacy_admin_path_redirects_to_admin_app_login(): void
    {
        config()->set('peq.admin_app_url', 'https://admin.peq.test');

        $adminPath = trim((string) config('peq.admin_path'), '/');
        $legacyAdminPath = trim((string) config('peq.legacy_admin_path'), '/');

        if ($legacyAdminPath === '' || $legacyAdminPath === $adminPath) {
            $this->markTestSkipped('Legacy admin path redirect is disabled in config.');
        }

        $this->get('/'.$legacyAdminPath)
            ->assertRedirect('https://admin.peq.test/'.$adminPath.'/login');
    }

    public function test_legacy_admin_login_path_redirects_to_admin_app_login(): void
    {
        config()->set('peq.admin_app_url', 'https://admin.peq.test/');

        $adminPath = trim((string) config('peq.admin_path'), '/');
        $legacyAdminPath = trim((string) config('peq.legacy_admin_path'), '/');

        if ($legacyAdminPath === '' || $legacyAdminPath === $adminPath) {
            $this->markTestSkipped('Legacy admin path redirect is disabled in config.');
        }

        $this->get('/'.$legacyAdminPath.'/login')
            ->assertRedirect('https://admin.peq.test/'.$adminPath.'/login');
    }

    public function test_legacy_admin_login_post_keeps_non_admin_outcome_on_public_app(): void
    {
        config()->set('peq.admin_app_url', 'https://admin.peq.test');

        $adminPath = trim((string) config('peq.admin_path'), '/');
        $legacyAdminPath = trim((string) config('peq.legacy_admin_path'), '/');

        if ($legacyAdminPath === '' || $legacyAdminPath === $adminPath) {
            $this->markTestSkipped('Legacy admin path redirect is disabled in config.');
        }

        $this->post('/'.$legacyAdminPath.'/login', [
            'email' => 'legacy-admin@example.com',
            'password' => 'secret',
        ])->assertRedirect('https://admin.peq.test/'.$adminPath.'/login');

        $this->assertGuest();
    }

    public function test_public_customer_routes_keep_working_with_admin_redirect_policy(): void
    {
        config()->set('peq.admin_app_url', 'https://admin.peq.test');

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('PIDE LA TUYA');

        $this->get(route('store.home'))
            ->assertOk();

        $this->get(route('member.login'))
            ->assertOk();
    }

    public function test_public_login_path_is_not_exposed(): void
    {
        $this->get('/login')->assertNotFound();
    }
}
