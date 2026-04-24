# Phase 1 Baseline Runbook

## Lift-and-shift invariants
- Keep the current data model, controllers, Blade templates, routes, and business rules unchanged unless separation requires a boundary update.
- Keep both apps on the same Laravel and PHP versions during extraction.
- Keep shared database access in phase 1 to avoid behavior drift.

## No behavior change rule
- Do not redesign admin workflows, validation copy, reporting criteria, or approval logic.
- Any unavoidable change caused by app separation must be documented and approved before release.

## Rollback trigger
- Trigger rollback if parity-critical admin or storefront workflows fail during baseline verification.
- Roll back by redeploying the previous single-app release and pausing split-specific promotion.
