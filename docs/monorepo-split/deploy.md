# Monorepo Split Deploy Guide

## Scope
- Public app: `apps/public` serves storefront and member flows only.
- Admin app: `apps/admin` serves private admin routes only (`ADMIN_PATH`).
- Phase-1 data/runtime: shared database and shared queue infrastructure, with admin queue namespaced by `QUEUE_NAMESPACE=peq-admin`.

## Required Environment Baseline
| Variable | Public (`apps/public`) | Admin (`apps/admin`) |
|---|---|---|
| `APP_NAME` | `peq-public` | `peq-admin` |
| `APP_URL` | Public host URL | Admin host URL |
| `SESSION_COOKIE` | `peq_public_session` | `peq_admin_session` |
| `ADMIN_APP_URL` | Absolute admin URL for redirects | Same as `APP_URL` |
| `ADMIN_HOST` | n/a | Admin host name |
| `ADMIN_ALLOWED_HOSTS` | n/a | Comma-separated allowlist |
| `ADMIN_ALLOWED_EMAILS` | Optional (kept for shared auth config parity) | Required in production |
| `DB_*` | Shared DB connection | Shared DB connection |
| `QUEUE_CONNECTION` | Shared queue backend | Shared queue backend |
| `QUEUE_NAMESPACE` | Optional | `peq-admin` |

## Deployment Topology
1. Build and release `apps/public` and `apps/admin` independently.
2. Route public host traffic only to `apps/public`.
3. Route admin host traffic only to `apps/admin`.
4. Keep the same database schema for both apps during phase 1.
5. Keep queue workers shared, but monitor admin jobs through namespaced queue names.

## Release Order (Recommended)
1. Deploy `apps/admin` first.
2. Smoke test admin login, dashboard, cakes, discounts, reports.
3. Deploy `apps/public` with legacy admin redirect pointing to `ADMIN_APP_URL`.
4. Smoke test storefront checkout/member flow and legacy admin redirect.

## Rollback Procedure
1. Roll back the last changed app only (public or admin) to the previous release artifact.
2. Re-run app-specific smoke checks:
   - Public: storefront route + order submission.
   - Admin: login + dashboard + CRUD/report key routes.
3. If rollback was admin, keep public host untouched; legacy admin redirects still target admin host.
4. If rollback was public, keep admin host untouched; admin runtime/auth/session stays isolated.

## Operational Notes
- Public and admin session cookies must stay distinct to avoid cross-app privilege leakage.
- Any forced schema migration affecting shared tables must be backward-compatible across staggered app versions.
- Do not introduce admin routes back into `apps/public/routes/web.php`.
