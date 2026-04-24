<?php

namespace Tests\Feature;

use Tests\TestCase;

class MonorepoSplitPhase1BaselineTest extends TestCase
{
    public function test_phase1_creates_public_and_admin_apps(): void
    {
        $repoRoot = $this->resolveRepositoryRoot();

        $this->assertDirectoryExists($repoRoot.'/apps/public');
        $this->assertDirectoryExists($repoRoot.'/apps/admin');
    }

    private function resolveRepositoryRoot(): string
    {
        $basePath = str_replace('\\', '/', base_path());

        if (str_ends_with($basePath, '/apps/public') || str_ends_with($basePath, '/apps/admin')) {
            return dirname(dirname($basePath));
        }

        return dirname($basePath);
    }
}
