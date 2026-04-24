<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteSmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_is_not_exposed_as_storefront_in_admin_app(): void
    {
        $this->get('/')->assertNotFound();
    }

    public function test_storefront_route_is_not_exposed_in_admin_app(): void
    {
        $storePath = trim((string) config('peq.store_path', 'tienda'), '/');

        $this->get('/'.$storePath)->assertNotFound();
    }

    public function test_member_auth_routes_are_not_exposed_in_admin_app(): void
    {
        $this->get('/socio/login')->assertNotFound();
        $this->post('/socio/login')->assertNotFound();
    }

    public function test_admin_configured_path_requires_authentication(): void
    {
        $adminPath = '/'.trim((string) config('peq.admin_path'), '/');
        $adminLoginPath = $adminPath.'/login';

        $this->get($adminPath)->assertRedirect($adminLoginPath);
    }

    public function test_legacy_admin_path_redirects_to_login_for_guests(): void
    {
        $legacyAdminPath = trim((string) config('peq.legacy_admin_path'), '/');

        if ($legacyAdminPath === '' || $legacyAdminPath === trim((string) config('peq.admin_path'), '/')) {
            $this->markTestSkipped('Legacy admin path redirect is disabled in config.');
        }

        $adminLoginPath = '/'.trim((string) config('peq.admin_path'), '/').'/login';

        $this->get('/'.$legacyAdminPath)->assertRedirect($adminLoginPath);
    }

    public function test_public_login_path_is_not_exposed(): void
    {
        $this->get('/login')->assertNotFound();
    }
}
