# Post-Cutover Cleanup Backlog - Phase 5.3

## Objective
Track deferred cleanup items to execute after the stabilization window, without risking lift-and-shift parity during cutover.

## Stabilization Gate
- Start this backlog only after 2 consecutive green production smoke windows for both public and admin apps.

## Backlog Items
| ID | Priority | Scope | Action | Owner | Done When |
|---|---|---|---|---|---|
| C-01 | High | Tests | Remove any remaining stale cross-surface assumptions if reintroduced (public must not assert admin route handlers; admin must not assert storefront/member endpoints). | QA/Backend | Full suites remain green with strict ownership boundaries. |
| C-02 | High | Redirect compatibility | Evaluate retirement of legacy admin redirect routes once external links/bookmarks have migrated. | Product + Backend | Legacy path traffic is negligible and rollback policy allows removal. |
| C-03 | Medium | CI gates | Add a release-branch mandatory job that always runs full `vendor/bin/phpunit` in both apps. | DevOps | Merge blocked when either app full suite fails. |
| C-04 | Medium | Observability | Add dashboard/alerts per app for auth failures, redirect spikes, and queue lag to detect cross-app regressions quickly. | DevOps | Alerts configured with runbooks and on-call ownership. |
| C-05 | Medium | Queue topology | Reassess shared worker strategy and decide whether to split public/admin workers after traffic baseline. | Backend + DevOps | Decision recorded and infra change plan approved. |
| C-06 | Low | Code sharing | Review duplicate-first files and identify safe candidates for shared package extraction (only if drift appears). | Tech Lead | ADR approved with migration plan and no behavior change risk. |

## Explicitly Deferred (Out of Current Change)
- Database/domain decomposition between public and admin contexts.
- Internal admin API introduction.
- UI/UX redesign of admin or storefront workflows.
