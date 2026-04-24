# Parity Evidence - Phase 5.1

## Objective
Confirm split parity readiness by running full PHPUnit suites in both apps and mapping required admin/public scenarios to passing coverage.

## Execution Date
- 2026-04-24

## Full Suite Commands
```bash
# apps/public
vendor/bin/phpunit

# apps/admin
vendor/bin/phpunit
```

## Full Suite Results
| App | Result |
|---|---|
| `apps/public` | PASS (`65 tests, 316 assertions`) |
| `apps/admin` | PASS (`60 tests, 243 assertions`) |

## Required Scenario Parity Matrix
| Requirement | Scenario | Evidence | Result |
|---|---|---|---|
| Public scope excludes admin surface | Public host does not serve admin UI/login | `apps/public/tests/Feature/RouteSmokeTest.php` | PASS |
| Public customer parity retained | Storefront and ordering flow unchanged | `apps/public/tests/Feature/PublicControllerTest.php` | PASS |
| App-scoped admin auth parity | Admin roles/allowlist keep same authorization behavior | `apps/admin/tests/Feature/AdminAuthBoundaryParityTest.php` | PASS |
| Session boundary isolation | Public cookie does not authenticate admin actions | `apps/admin/tests/Feature/AdminAuthBoundaryParityTest.php` | PASS |
| Admin CRUD/report parity | Admin cakes/discounts/reports continue with expected outcomes | `apps/admin/tests/Feature/AdminCakeCrudTest.php`, `apps/admin/tests/Feature/AdminDiscountCrudTest.php`, `apps/admin/tests/Feature/AdminReportsTest.php` | PASS |
| Independent admin boundary | Admin route ownership remains inside admin app only | `apps/admin/tests/Feature/RouteSmokeTest.php`, `apps/public/tests/Feature/RouteSmokeTest.php` | PASS |

## Notes
- `MonorepoSplitPhase1BaselineTest` now resolves repo root correctly from `apps/public` and `apps/admin` test contexts.
- Legacy cross-boundary test files were removed from the wrong app test suites to align with split ownership.
