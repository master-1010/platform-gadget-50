# Security Design Baseline

## Current controls

- Laravel CSRF middleware and hashed passwords
- Server-side request validation on the existing forms
- Route throttles for likes and comments
- Admin middleware for the current administration routes
- Image validation on the existing post upload path
- Escaped Blade output for untrusted text
- Installation lock file outside the public document root

## Required hardening

- Replace the single role check with policies and explicit permissions
- Add failed-login records, per-account lockouts, and configurable expiry
- Add password reset, verification, and optional TOTP 2FA
- Sanitize rich content using an allow-list, never arbitrary HTML
- Add audit logs for authentication, moderation, settings, and security actions
- Encrypt sensitive settings and never log credentials or authentication secrets
- Add privacy-conscious view/like deduplication and retention rules
- Add upload MIME, dimension, storage, and orphan-file controls

## Secure defaults

Production deployments must use HTTPS, `APP_DEBUG=false`, a private `.env`, a document root of `public/`, secure session cookies, a supported queue worker, and scheduled tasks where enabled. The application must fail clearly when email delivery is disabled instead of claiming a message was delivered.
