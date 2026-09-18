# Architecture Decision Record

## Locked baseline

- Laravel 11 on PHP 8.2+
- MySQL/MariaDB with Eloquent and migrations
- Blade as the server-rendered UI; Alpine/Tailwind may be introduced consistently
- Laravel authentication, policies, validation, filesystem, notifications, queues, and scheduler
- Named routes and route model binding for public URLs
- Configuration through environment variables and database-backed settings only where explicitly required

## Application boundaries

- `app/Http/Controllers`: request orchestration only
- `app/Models`: persistence and relationships
- `app/Policies`: authorization decisions
- `app/Services`: reusable business workflows
- `app/Notifications` and `app/Mail`: outbound messages
- `app/Rules` and Form Requests: input validation
- `resources/views`: presentation only
- `database/migrations`: additive schema changes; existing migrations are not rewritten after deployment

## Change policy

Every feature must include its schema change, authorization, validation, UI, tests, and documentation. Existing implementations are reused or refactored before new classes are added. No duplicate route, migration, controller, settings key, or permission is introduced.

## Current vertical slice

The repository already contains the initial public post, account, installation, moderation, comment, and like slice. Subsequent work must harden and extend it instead of replacing it.
