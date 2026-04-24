<?php

namespace Tests\Unit;

use Tests\TestCase;

class AdminQueueNamespaceConfigTest extends TestCase
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

    public function test_queue_config_namespaces_default_queue_names_using_app_name_fallback(): void
    {
        $this->setEnvironmentValue('APP_NAME', 'PEQ Admin');
        $this->setEnvironmentValue('QUEUE_NAMESPACE', '');
        $this->setEnvironmentValue('DB_QUEUE', '');
        $this->setEnvironmentValue('REDIS_QUEUE', '');
        $this->setEnvironmentValue('BEANSTALKD_QUEUE', '');
        $this->setEnvironmentValue('SQS_QUEUE', '');

        $queueConfig = require config_path('queue.php');

        $this->assertSame('peq-admin-default', $queueConfig['connections']['database']['queue']);
        $this->assertSame('peq-admin-default', $queueConfig['connections']['redis']['queue']);
        $this->assertSame('peq-admin-default', $queueConfig['connections']['beanstalkd']['queue']);
        $this->assertSame('peq-admin-default', $queueConfig['connections']['sqs']['queue']);
        $this->assertSame('jobs', $queueConfig['connections']['database']['table']);
    }

    public function test_queue_config_uses_explicit_queue_namespace_for_observability(): void
    {
        $this->setEnvironmentValue('APP_NAME', 'PEQ Admin');
        $this->setEnvironmentValue('QUEUE_NAMESPACE', ' Admin.Core ');
        $this->setEnvironmentValue('DB_QUEUE', '');
        $this->setEnvironmentValue('REDIS_QUEUE', '');
        $this->setEnvironmentValue('BEANSTALKD_QUEUE', '');
        $this->setEnvironmentValue('SQS_QUEUE', '');

        $queueConfig = require config_path('queue.php');

        $this->assertSame('admin-core-default', $queueConfig['connections']['database']['queue']);
        $this->assertSame('admin-core-default', $queueConfig['connections']['redis']['queue']);
        $this->assertSame('admin-core-default', $queueConfig['connections']['beanstalkd']['queue']);
        $this->assertSame('admin-core-default', $queueConfig['connections']['sqs']['queue']);
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
