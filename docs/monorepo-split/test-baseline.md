# Phase 1 Verification Checkpoint

Baseline run captured after monorepo foundation extraction (task 1.4).

| App | Command | Result |
|---|---|---|
| `apps/public` | `php artisan test` | FAIL (11 failed, 70 passed, 369 assertions) |
| `apps/admin` | `php artisan test` | FAIL (11 failed, 70 passed, 369 assertions) |

## Failure Notes
- `AdminDashboardTest`: cutoff time assertion expects `09:30:00`, persisted value is `09:30`.
- `AdminDiscountCrudTest`: expected redirect to `route('store.home')` mismatches actual `/` redirect.
- `AdminReportsTest`: route `admin.reports.monthly-orders` is missing and index expectation still checks `name="month"`.
- `MemberTest`: login tests expect identifier-only flow, current validation requires password; level reset assertion mismatch.
- `MonorepoSplitPhase1BaselineTest`: when run inside copied apps, repo-root path resolution checks `apps/apps/public` instead of `apps/public`.
