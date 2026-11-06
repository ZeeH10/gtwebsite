# Glad Tidings Fellowship – Bethel Centre website

Laravel 13 + Tailwind CSS 4 (Vite) public site, a Filament 5 admin at `/admin`, and an installable PWA.

- **Public pages:** Home, About, Ministries & home groups, Events, Watch, Give, Visit us, I’m new here (connect card), Ask for prayer, Privacy. Views in `resources/views/`, shared header/footer in `components/layout.blade.php`.
- **Admin (`/admin`):** Inbox (prayer requests, connect cards), People (members, home groups, CSV import), Website (events, ministries, service times, sermons & videos, site settings), Settings (staff logins).
- **Roles:** Super admin (everything incl. staff logins), Admin / communications, Pastor (only role that sees *pastors-only* prayers), Media team (website content), Home group leader (own group only). Access is enforced in `app/Filament/Concerns/RestrictedToRoles.php` plus each resource's `getEloquentQuery()`.

## Editing content
Staff edit content in `/admin`. `config/church.php` holds fixed details (address, phones, Facebook) and the **starter content** the seeder copies into the database. Pastor bio, story, banking details, YouTube and the POPIA Information Officer are under **Website → Site settings**.

## Local development
```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
# set ADMIN_NAME / ADMIN_EMAIL / ADMIN_PASSWORD in .env for the first login
php artisan migrate --seed
php artisan storage:link
npm run build      # or `npm run dev` while editing
php artisan serve
```
Needs PHP 8.3+ with the `intl` extension (Filament). Run tests: `php artisan test`.

## Importing the member spreadsheet
In Excel: *File → Save As → CSV*. Then **People → Import from spreadsheet (CSV)** in `/admin`, and match the columns. Rows with an email or phone already on file update that person instead of duplicating. Status accepts “member”, “visitor” or “past”.

## PWA (install on phones)
`public/manifest.webmanifest`, icons in `public/images/icon-*.png`, service worker `public/sw.js` (offline page at `/offline`). Android Chrome offers “Install app”; on iPhone use Share → Add to Home Screen. The site must be on HTTPS (cPanel AutoSSL). After changing `/offline` content, bump `VERSION` in `sw.js`.

## Deploying to HostAfrica (cPanel)
1. `npm run build` locally (the host does not need Node).
2. cPanel → **Select PHP Version**: PHP 8.3+, enable `intl`, `fileinfo`, `zip`, `pdo_mysql`.
3. Create a MySQL database + user, and an email account for sending mail.
4. Upload the project (without `node_modules`) to e.g. `~/gtwebsite`, then point the domain's document root at `~/gtwebsite/public` (cPanel → Domains).
5. In cPanel Terminal: `composer install --no-dev --optimize-autoloader`.
6. Create `.env` from `.env.example`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://…`, `DB_CONNECTION=mysql` + credentials, SMTP `MAIL_*`, `CHURCH_EMAIL` (receives prayer requests and connect cards), `ADMIN_*` for the first login.
7. ```bash
   php artisan key:generate && php artisan migrate --seed --force && php artisan storage:link
   php artisan filament:assets && php artisan optimize && php artisan filament:optimize
   ```
8. Turn on **AutoSSL** (HTTPS) and **JetBackup** backups. `QUEUE_CONNECTION=sync` means imports run immediately; no cron or queue worker is needed yet.

Prayer requests and connect cards are always stored in the database, and also emailed when `CHURCH_EMAIL` is set.
