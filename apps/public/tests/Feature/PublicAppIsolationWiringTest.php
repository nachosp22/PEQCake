<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class PublicAppIsolationWiringTest extends TestCase
{
    public function test_admin_access_middleware_alias_is_not_registered_in_public_app(): void
    {
        $aliases = app('router')->getMiddleware();

        $this->assertArrayNotHasKey('admin.access', $aliases);
    }

    public function test_admin_only_controllers_are_not_available_in_public_app_namespace(): void
    {
        $this->assertFileDoesNotExist(app_path('Http/Controllers/AdminController.php'));
        $this->assertFileDoesNotExist(app_path('Http/Controllers/AuthController.php'));
        $this->assertFileDoesNotExist(app_path('Http/Controllers/Admin/CakeController.php'));
    }

    public function test_member_auth_routes_remain_mapped_for_public_host(): void
    {
        $routes = app('router')->getRoutes();

        $this->assertNotNull($routes->getByName('member.login'));
        $this->assertNotNull($routes->getByName('member.login.submit'));
        $this->assertNotNull($routes->getByName('member.logout'));
    }
}
