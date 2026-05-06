# SHIIS '05 Reunion Platform - Production Deployment Guide

This document outlines the steps required to move the application from your local environment to a live production server.

## 1. Server Requirements
- **PHP**: 8.2 or higher (8.5 recommended)
- **Extensions**: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Database**: SQLite (default) or MySQL/PostgreSQL
- **Web Server**: Apache or Nginx

## 2. Environment Configuration
Copy `.env.example` to `.env` on your server and update the following critical keys:

```env
APP_NAME="SHIIS '05 Reunion"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database (Ensure database/database.sqlite exists and is writable)
DB_CONNECTION=sqlite

# Mail Configuration (Crucial for Accountant alerts and Member activation)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io # Replace with your provider
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="no-reply@your-domain.com"
MAIL_FROM_NAME="SHIIS '05 Committee"

# Filesystem
FILESYSTEM_DISK=public
```

## 3. Deployment Commands
Run these commands in order on your production server:

```bash
# 1. Install dependencies
composer install --optimize-autoloader --no-dev

# 2. Generate security key
php artisan key:generate

# 3. Create database file (if using SQLite)
touch database/database.sqlite

# 4. Run migrations and seeders (Creates Admin & Accountant)
php artisan migrate --force
php artisan db:seed --force

# 5. Link storage for receipts and gallery images
php artisan storage:link

# 6. Production Optimizations
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 4. Cron Jobs (Automated Notifications)
The platform uses scheduled tasks for automated event notifications (May 30/31). Add the following entry to your server's crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 5. Queue Worker
Since the app queues emails for performance, you must run a queue worker in the background:

```bash
php artisan queue:work --tries=3
```
*(Tip: Use a process manager like **Supervisor** to keep this running automatically).*

## 6. Security Checklist
- [ ] `APP_DEBUG` is set to `false`.
- [ ] Database file is not publicly accessible.
- [ ] `storage/` and `bootstrap/cache/` directories are writable by the web server.
- [ ] SSL (HTTPS) is active on the domain.

---
**SHIIS '05 Reunion Platform v1.0 Production Ready**
