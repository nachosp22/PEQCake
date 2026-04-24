<?php

$adminAppUrl = (string) env('ADMIN_APP_URL', env('APP_URL', 'http://localhost'));
$adminHost = strtolower(trim((string) env('ADMIN_HOST', (string) parse_url($adminAppUrl, PHP_URL_HOST))));
$adminAllowedHosts = array_values(array_filter(array_map(
    static fn (string $host): string => strtolower(trim($host)),
    explode(',', (string) env('ADMIN_ALLOWED_HOSTS', ''))
)));

if ($adminAllowedHosts === [] && $adminHost !== '') {
    $adminAllowedHosts = [$adminHost];
}

return [
    'admin_app_url' => $adminAppUrl,
    'admin_host' => $adminHost,
    'admin_allowed_hosts' => $adminAllowedHosts,
    'admin_path' => (string) env('ADMIN_PATH', 'panel-62f0f6d8c9b14e71a3'),
    'legacy_admin_path' => (string) env('LEGACY_ADMIN_PATH', 'peqcakes-panel-seguro-2026'),
    'store_path' => (string) env('STORE_PATH', 'tienda'),
    'public_hero_video_enabled' => (bool) env('PEQ_PUBLIC_HERO_VIDEO_ENABLED', true),
    'public_hero_video_mobile_autoplay' => (bool) env('PEQ_PUBLIC_HERO_VIDEO_MOBILE_AUTOPLAY', false),
    'ga4_measurement_id' => (string) env('PEQ_GA4_MEASUREMENT_ID', ''),
    'agenda_cutoff_time' => (string) env('PEQ_AGENDA_CUTOFF_TIME', '10:00'),
    'agenda_min_days_before_cutoff' => (int) env('PEQ_AGENDA_MIN_DAYS_BEFORE_CUTOFF', 1),
    'agenda_min_days_after_cutoff' => (int) env('PEQ_AGENDA_MIN_DAYS_AFTER_CUTOFF', 2),
];
