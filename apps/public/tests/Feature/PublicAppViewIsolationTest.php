<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

final class PublicAppViewIsolationTest extends TestCase
{
    public function test_public_app_has_no_admin_blade_entrypoint_templates(): void
    {
        $this->assertFileDoesNotExist(resource_path('views/admin/dashboard.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/cakes/index.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/discounts/index.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/members/index.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/members/edit.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/agenda/index.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/reports/index.blade.php'));
        $this->assertFileDoesNotExist(resource_path('views/admin/partials/top-nav.blade.php'));
    }

    public function test_public_app_has_no_auth_login_admin_entrypoint_template(): void
    {
        $this->assertFileDoesNotExist(resource_path('views/auth/login.blade.php'));
    }

    public function test_landing_route_does_not_render_admin_navigation_call_to_action(): void
    {
        $this->get(route('landing'))
            ->assertOk()
            ->assertDontSee('Acceso gestion')
            ->assertDontSee('href="/login"', false);
    }

    public function test_coming_soon_route_does_not_render_admin_navigation_call_to_action(): void
    {
        $this->get(route('landing.coming-soon'))
            ->assertOk()
            ->assertDontSee('Acceso gestion')
            ->assertDontSee('href="/login"', false);
    }
}
