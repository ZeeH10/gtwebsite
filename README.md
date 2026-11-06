# Glad Tidings Fellowship – Bethel Centre website

Laravel 13 + Tailwind CSS 4 (Vite). Pages: Home, About, Ministries, Events, Watch, Give, Visit & Contact, Prayer request.
Shared header/footer live in `resources/views/components/layout.blade.php`; each page is a view in `resources/views/`.

## Editing content
Almost everything (service times, ministries, events, banking details, contacts) lives in
`config/church.php`. Items marked `PLACEHOLDER` still need real details.
Images live in `public/images/` (current photos are AI-generated placeholders from Gemini).

## Local development
```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
php artisan migrate
npm run build      # or `npm run dev` while editing
php artisan serve
```
Run tests: `php artisan test`

## Deploying to HostAfrica (cPanel)
1. `npm run build` locally (the host does not need Node).
2. Create a MySQL database + user in cPanel.
3. Upload the project (without `node_modules`) to e.g. `~/gtwebsite`, then point the domain's
   document root at `~/gtwebsite/public` (cPanel → Domains). If that isn't possible, copy the
   contents of `public/` into `public_html` and fix the two paths in `public_html/index.php`.
4. In cPanel Terminal: `composer install --no-dev --optimize-autoloader`.
5. Create `.env` from `.env.example`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL`,
   `DB_CONNECTION=mysql` + credentials, SMTP `MAIL_*` from a cPanel email account,
   and `CHURCH_EMAIL` (where prayer requests are sent).
6. `php artisan key:generate && php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache`
7. Select PHP 8.3+ in cPanel → "Select PHP Version".

Prayer requests are always stored in the `prayer_requests` table, and also emailed when `CHURCH_EMAIL` is set.
