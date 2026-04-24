<?php

namespace Tests\Unit;

use Tests\TestCase;

class AdminRuntimeBoundaryConfigTest extends TestCase
{
    /**
     * @var array<string, string|false>
     */
    private array $originalEnvironment = [];

    protected function tearDown(): void
    {
        foreach ($this->originalEnvironment as $key => $value) {
            if ($value === false) {
                putenv($key);
                unset($_ENV[$key], $_SERVER[$key]);

                continue;
            }

            putenv($key.'='.$value);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        parent::tearDown();
    }

    public function test_auth_config_parses_admin_allowlist_hosts_from_env(): void
    {
        $this->setEnvironmentValue('APP_URL', 'https://www.peq.test');
        $this->setEnvironmentValue('ADMIN_APP_URL', 'https://admin.peq.test');
        $this->setEnvironmentValue('ADMIN_ALLOWED_HOSTS', 'admin.peq.test, Admin-Backup.peq.test, ,');
        $this->setEnvironmentValue('ADMIN_ALLOWED_EMAILS', 'owner@peq.test, support@peq.test');

        $authConfig = require config_path('auth.php');

        $this->assertArrayHasKey('admin_allowed_hosts', $authConfig);
        $this->assertSame(['admin.peq.test', 'admin-backup.peq.test'], $authConfig['admin_allowed_hosts']);
        $this->assertSame(['owner@peq.test', 'support@peq.test'], $authConfig['admin_emails']);
    }

    public function test_auth_config_falls_back_to_admin_host_when_allowlist_is_empty(): void
    {
        $this->setEnvironmentValue('ADMIN_APP_URL', 'https://admin.peq.test:8443');
        $this->setEnvironmentValue('ADMIN_ALLOWED_HOSTS', '');

        $authConfig = require config_path('auth.php');

        $this->assertSame(['admin.peq.test'], $authConfig['admin_allowed_hosts']);
    }

    public function test_peq_config_exposes_admin_runtime_host_values(): void
    {
        $this->setEnvironmentValue('APP_URL', 'https://www.peq.test');
        $this->setEnvironmentValue('ADMIN_APP_URL', 'https://admin.peq.test');
        $this->setEnvironmentValue('ADMIN_ALLOWED_HOSTS', 'admin.peq.test,admin-alt.peq.test');

        $peqConfig = require config_path('peq.php');

        $this->assertArrayHasKey('admin_app_url', $peqConfig);
        $this->assertArrayHasKey('admin_host', $peqConfig);
        $this->assertArrayHasKey('admin_allowed_hosts', $peqConfig);
        $this->assertSame('https://admin.peq.test', $peqConfig['admin_app_url']);
        $this->assertSame('admin.peq.test', $peqConfig['admin_host']);
        $this->assertSame(['admin.peq.test', 'admin-alt.peq.test'], $peqConfig['admin_allowed_hosts']);
    }

    public function test_peq_config_uses_admin_host_fallback_when_allowlist_missing(): void
    {
        $this->setEnvironmentValue('APP_URL', 'https://www.peq.test');
        $this->setEnvironmentValue('ADMIN_APP_URL', 'https://admin.peq.test');
        $this->setEnvironmentValue('ADMIN_ALLOWED_HOSTS', '');

        $peqConfig = require config_path('peq.php');

        $this->assertSame(['admin.peq.test'], $peqConfig['admin_allowed_hosts']);
    }

    private function setEnvironmentValue(string $key, string $value): void
    {
        if (! array_key_exists($key, $this->originalEnvironment)) {
            $this->originalEnvironment[$key] = getenv($key);
        }

        putenv($key.'='.$value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}
