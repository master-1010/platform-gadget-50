# Deployment Plan

## Runtime

- PHP 8.2 or newer with the Laravel-required extensions
- MySQL 8/MariaDB equivalent
- Composer and Node.js for builds
- Web server document root set to `public/`
- HTTPS certificate and a trusted proxy configuration where applicable

## Release steps

1. Upload the release or deploy from source.
2. Create a private `.env` from `.env.example` and configure the database.
3. Run `composer install --no-dev --optimize-autoloader`.
4. Run `php artisan migrate --force`.
5. Run `php artisan storage:link` where supported.
6. Build frontend assets with `npm ci && npm run build`.
7. Run `php artisan config:cache`, `route:cache`, and `view:cache` after configuration is correct.
8. Run a queue worker under Supervisor/systemd if queues are enabled.
9. Schedule `php artisan schedule:run` every minute if scheduled jobs are enabled.
10. Verify `/up`, login, public posts, uploads, mail configuration, and backups.

Do not expose `.env`, storage internals, database credentials, or application logs through the web server. Shared hosting without shell access should use its control panel for environment variables, cron, queue alternatives, and database creation; automatic server reconfiguration is intentionally not attempted.
