# AGENTS.md

## Cursor Cloud specific instructions

SelfBrew Admin is a single Laravel 10 web app (PHP 8.3, MySQL, Blade + Tailwind/Vite). Standard setup/run commands live in `README.md`; only non-obvious cloud caveats are noted here.

### Services
- **Laravel app** (`php artisan serve`) — the product, served on port 8000.
- **Vite dev server** (`npm run dev`) — serves frontend assets/HMR on port 5173. Required in dev so Blade `@vite` directives resolve (running `npm run dev` writes `public/hot`, switching the app to the dev server; delete `public/hot` or run `npm run build` to use compiled assets instead).
- **MySQL 8** — required; database `selfbrew_admin`, connection uses `root` over TCP with empty password (matches `.env`).

### Startup caveats (the dependency update script does NOT do these)
- MySQL is not auto-started. Start it each session with `sudo service mysql start` (data persists in the VM snapshot, so don't re-run migrations unless the DB is empty).
- The app connects as `root`@`127.0.0.1` with an empty password. This account is created in addition to the default socket-auth `root`@`localhost`; if the DB is ever reset, recreate it: `CREATE USER 'root'@'127.0.0.1' IDENTIFIED WITH mysql_native_password BY ''; GRANT ALL PRIVILEGES ON *.* TO 'root'@'127.0.0.1' WITH GRANT OPTION;`.
- `.env` and `APP_KEY` already exist in the snapshot. On a truly fresh checkout: `cp .env.example .env && php artisan key:generate`, then `php artisan migrate --seed` and `php artisan storage:link`.
- Demo admin login: `admin@selfbrew.coko` / `password`.

### Lint / test notes
- Lint: `./vendor/bin/pint --test` (fix with `./vendor/bin/pint`). On stock code this reports pre-existing style nits in framework/config files — not caused by your changes.
- Tests: `php artisan test`. The default `Tests\Feature\ExampleTest` fails out of the box because it GETs `/` expecting 200, but `/` redirects (302) to `/login`; this is a pre-existing test mismatch, not an environment problem. PHPUnit runs against the configured MySQL DB (the in-memory SQLite lines in `phpunit.xml` are commented out).
