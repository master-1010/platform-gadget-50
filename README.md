# Platform Gadget 50

Reusable Laravel public news and citizen-journalism platform.

## Project status

This repository is being implemented in controlled phases. The current code is a working foundation/vertical slice, not yet the complete Master Prompt scope. See `FEATURE-MATRIX.md` for the authoritative status and `ARCHITECTURE.md` for the no-duplication change policy.

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

Point the web server document root at `public/`, set `APP_ENV=production` and `APP_DEBUG=false`, configure HTTPS and trusted proxies, then follow `DEPLOYMENT-PLAN.md`. Never commit `.env`.

## Security

Passwords use Laravel hashing, forms use CSRF protection, uploads are image-only and stored through the filesystem, public content is escaped, posts require admin approval, and admin routes are protected. The default mailer is `log` and does not claim delivery. See `SECURITY-DESIGN.md` for the hardening roadmap.
