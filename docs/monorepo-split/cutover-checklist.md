# Legacy Admin URL Cutover Checklist

## Preconditions
- [ ] Admin app is deployed and reachable at `ADMIN_APP_URL`.
- [ ] `ADMIN_PATH` is configured in `apps/admin` and matches expected hidden route.
- [ ] Public app has `ADMIN_APP_URL` configured for legacy redirect behavior.
- [ ] Admin allowlist (`ADMIN_ALLOWED_EMAILS`) is configured for production.
- [ ] Session cookies are distinct (`peq_public_session` vs `peq_admin_session`).

## Pre-Cutover Verification
- [ ] Public smoke checks pass (`storefront`, `checkout`, `member`).
- [ ] Admin smoke checks pass (`login`, `dashboard`, `cakes`, `discounts`, `reports`).
- [ ] Route ownership verified:
  - [ ] Public host does not expose admin UI routes.
  - [ ] Admin host does not expose storefront/member routes.

## Cutover Steps
1. Deploy latest `apps/admin` release.
2. Deploy latest `apps/public` release with redirect target `ADMIN_APP_URL`.
3. Validate legacy entrypoint on public host (`/{LEGACY_ADMIN_PATH}`) returns redirect to admin dashboard path.
4. Validate direct admin login path works on admin host.
5. Validate non-admin users cannot establish admin session.

## Post-Cutover Validation
- [ ] Public checkout still succeeds.
- [ ] Admin CRUD/report workflows preserve expected business outcomes.
- [ ] Public session does not grant admin access.
- [ ] Error/forbidden behavior for unauthorized admin access remains intact.

## Rollback Trigger Conditions
- [ ] Admin login inaccessible after cutover.
- [ ] Public checkout regression.
- [ ] Redirect loop or invalid redirect target for legacy admin path.
- [ ] Authorization parity failure (admins blocked incorrectly or non-admins granted access).

## Rollback Actions
1. Roll back the impacted app release.
2. Re-run smoke checks for both hosts.
3. Document incident impact and config deltas before reattempting cutover.
