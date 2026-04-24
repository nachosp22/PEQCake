# Public Surface Audit - Phase 5.2

## Objective
Verify the public app does not expose admin runtime surface after the monorepo split.

## Review Date
- 2026-04-24

## Route-Level Audit

### Public app (`apps/public`)
- `php artisan route:list --path=admin` -> no direct admin handler routes found.
- `php artisan route:list --name=admin` -> only redirect compatibility routes:
  - `admin.redirect`
  - `admin.login.redirect`
  - `admin.legacy.redirect`
  - `admin.legacy.login.redirect`

### Admin app (`apps/admin`)
- `php artisan route:list --name=admin` -> 27 admin-owned routes (`admin.dashboard`, `admin.cakes.*`, `admin.discounts.*`, `admin.members.*`, `admin.reports.*`, agenda/blocked-day/order actions).

## Code-Level Audit
- `apps/public/routes/web.php` keeps customer/member endpoints and explicit redirect-only compatibility routes for legacy admin URLs.
- No admin controller class remains in `apps/public/app/Http/Controllers` (`*Admin*.php` search returns empty).

## Exceptions
- Redirect compatibility routes intentionally remain in public app for cutover safety:
  - `/{ADMIN_PATH}` and `/{ADMIN_PATH}/login`
  - `/{LEGACY_ADMIN_PATH}` and `/{LEGACY_ADMIN_PATH}/login` (when legacy path differs)
- These routes do not establish admin sessions in public app; they only redirect to admin host login.

## Verdict
- PASS: public app excludes admin functional surface, with documented redirect exceptions only.
