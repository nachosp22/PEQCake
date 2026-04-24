<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

$baseDir = __DIR__;

if (!file_exists($baseDir.'/vendor/autoload.php') && file_exists(dirname(__DIR__).'/vendor/autoload.php')) {
    $baseDir = dirname(__DIR__);
}

if (!file_exists($baseDir.'/vendor/autoload.php') || !file_exists($baseDir.'/bootstrap/app.php')) {
    http_response_code(500);
    header('Content-Type: text/plain; charset=UTF-8');
    echo '500 Setup path error: vendor/autoload.php or bootstrap/app.php not found.';
    exit;
}

$lockFile = $baseDir.'/storage/app/setup.lock';

if (file_exists($lockFile)) {
    http_response_code(410);
    header('Content-Type: text/plain; charset=UTF-8');
    echo '410 Gone: setup already executed. Delete setup.php and keep lock file.';
    exit;
}

require $baseDir . '/vendor/autoload.php';

$app = require_once $baseDir . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h3>Legacy setup.php</h3>";
echo "<p>One-time deploy endpoint.</p>";

$adminEmail = strtolower(trim((string) env('SETUP_ADMIN_EMAIL', '')));
$adminName = trim((string) env('SETUP_ADMIN_NAME', 'Administrador PEQ'));
$adminPassword = (string) env('SETUP_ADMIN_PASSWORD', '');
$configuredAdminEmails = array_values(array_filter(array_map(
    static fn (mixed $email): string => strtolower(trim((string) $email)),
    config('auth.admin_emails', [])
)));

if ($adminEmail === '' || filter_var($adminEmail, FILTER_VALIDATE_EMAIL) === false) {
    http_response_code(500);
    echo '<p>ERROR: invalid or missing SETUP_ADMIN_EMAIL in .env</p>';
    exit;
}

if (strlen($adminPassword) < 12) {
    http_response_code(500);
    echo '<p>ERROR: SETUP_ADMIN_PASSWORD must be at least 12 characters.</p>';
    exit;
}

if ($configuredAdminEmails === [] || ! in_array($adminEmail, $configuredAdminEmails, true)) {
    http_response_code(500);
    echo '<p>ERROR: ADMIN_ALLOWED_EMAILS must include SETUP_ADMIN_EMAIL.</p>';
    exit;
}

try {
    Artisan::call('migrate', ['--force' => true]);
    echo '<pre>' . htmlspecialchars(Artisan::output(), ENT_QUOTES, 'UTF-8') . '</pre>';
    echo "<p>OK: migrations completed.</p>";

    Artisan::call('app:setup-admin', [
        '--email' => $adminEmail,
        '--name' => $adminName,
        '--password' => $adminPassword,
    ]);
    echo '<pre>' . htmlspecialchars(Artisan::output(), ENT_QUOTES, 'UTF-8') . '</pre>';
    echo "<p>OK: admin user provisioned.</p>";

    if (!is_dir(dirname($lockFile))) {
        mkdir(dirname($lockFile), 0775, true);
    }

    file_put_contents(
        $lockFile,
        'executed_at='.date(DATE_ATOM).PHP_EOL.'remote_addr='.($_SERVER['REMOTE_ADDR'] ?? 'unknown').PHP_EOL,
        LOCK_EX
    );
    echo "<p>OK: setup lock created.</p>";
} catch (Throwable $exception) {
    echo "<p>ERROR: " . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
}
