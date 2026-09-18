# Platform Gadget 50

Reusable Laravel public news and citizen-journalism platform. This repository contains the working application foundation: public publishing, accounts, moderation, comments, likes, installation checks, and an admin area.

## Requirements

- PHP 8.2+
- MySQL/MariaDB
- Composer
- Node.js 20+ and npm

## Local installation

```bash
composer install
cp .env.example .env
php artisan key:generate
# Set DB_* values in .env
php artisan migrate --seed
php artisan storage:link
npm install && npm run build
php artisan serve
```

On a fresh installation, `/install` tests the configured database and creates the first administrator. The installer never writes `.env` or exposes credentials; configure environment variables using the hosting panel or deployment system. To prevent reinstallation, it creates `storage/app/installed.lock`.

## Production deployment

Point the web server document root at `public/`, set `APP_ENV=production` and `APP_DEBUG=false`, configure HTTPS and trusted proxies, run `php artisan migrate --force`, `php artisan storage:link`, `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache`. Run `php artisan queue:work --tries=3` under a process manager and schedule `php artisan schedule:run` every minute. Never commit `.env`.

## Security notes

Passwords use Laravel hashing, forms use CSRF protection, uploads are image-only and stored through the filesystem, public content is escaped, posts require admin approval, and admin routes are policy-protected. Configure SMTP with environment variables or a future encrypted settings provider; the default mailer is `log` and does not claim delivery.

## Scope and roadmap

The initial vertical slice is deliberately deployable and testable. Recommended next increments are Livewire admin tables, TOTP 2FA, encrypted SMTP settings, image variants, queued notifications, sitemap indexes, analytics consent, and a full audit-log viewer. Each should be added with migrations, policies, tests, and documented infrastructure requirements rather than placeholder controls.
