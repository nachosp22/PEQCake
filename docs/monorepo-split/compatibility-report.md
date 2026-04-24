# Compatibility Report - Staggered Deploy Simulation

## Objective
Validate that public app `N` and admin app `N+1` can run concurrently with shared DB/queues, and that admin rollback to `N` preserves critical workflows.

## Simulation Date
- 2026-04-24

## Executed Commands
```bash
apps/public/vendor/bin/phpunit --configuration apps/public/phpunit.xml apps/public/tests/Feature/RouteSmokeTest.php apps/public/tests/Feature/PublicControllerTest.php
apps/admin/vendor/bin/phpunit --configuration apps/admin/phpunit.xml apps/admin/tests/Feature/Admin* apps/admin/tests/Feature/RouteSmokeTest.php apps/admin/tests/Unit/AdminRuntimeBoundaryConfigTest.php apps/admin/tests/Unit/AdminQueueNamespaceConfigTest.php
apps/admin/vendor/bin/phpunit --configuration apps/admin/phpunit.xml apps/admin/tests/Feature/Admin* apps/admin/tests/Feature/RouteSmokeTest.php apps/admin/tests/Unit/AdminRuntimeBoundaryConfigTest.php apps/admin/tests/Unit/AdminQueueNamespaceConfigTest.php
```

## Results Matrix
| Stage | App Versions Simulated | Result |
|---|---|---|
| Baseline public validation | Public `N` | PASS (`32 tests, 193 assertions`) |
| Staggered deploy validation | Public `N` + Admin `N+1` | PASS (`41 tests, 178 assertions` for admin parity set) |
| Rollback validation | Public `N` + Admin rollback to `N` | PASS (`41 tests, 178 assertions` rerun) |

## Behavioral Findings
- Public storefront/member flows remain stable while admin parity tests run independently.
- Admin CRUD/report/auth/session boundary tests remain green during staggered and rollback simulation.
- No cross-app session escalation observed in admin parity suite (`public session cookie` does not authenticate admin routes).

## Risk Notes
- Simulation is test-harness based; production infra concerns (DNS, TLS, worker autoscaling) still require environment-level rehearsal.
- Shared DB remains a coupling point; schema changes must stay backward-compatible across temporary version skew.
