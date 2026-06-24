# AGENTS.md

## Cursor Cloud specific instructions

SelfBrew Admin is a single full-stack Laravel 10 app (MySQL + Blade + Tailwind/Vite) for a coffee-shop self-order kiosk admin. Standard setup/run commands live in `README.md`; only the non-obvious cloud caveats are below.

### Services & how to run them
- Database (MariaDB, stands in for MySQL): there is no systemd in this container, so start it manually before running the app or tests:
  `sudo mariadbd-safe --datadir=/var/lib/mysql &`
  A `skip-name-resolve` config is in place so that TCP clients match the `root@'127.0.0.1'` grant. The `selfbrew_admin` database is already created and `root@127.0.0.1` has an empty password (matching `.env`).
- Backend: `php artisan serve --host=0.0.0.0 --port=8000`. Root `/` redirects to `/login` by design.
- Frontend assets: `npm run dev` (Vite dev server on `localhost:5173`). Use `npm run dev`, not `npm run build`, for development.
- Admin login (seeded): `admin@selfbrew.coko` / `password`.

### Testing / lint notes
- Tests: `php artisan test`. The stock `Tests\Feature\ExampleTest` fails because it expects `/` to return 200, but this app redirects `/` to `/login` (302). This failure is pre-existing and unrelated to environment setup; do not "fix" it unless asked.
- Lint: `./vendor/bin/pint` (use `--test` to check without modifying). The repo has pre-existing style deviations that Pint will report.
- The MySQL `enum` columns in migrations mean the test DB should be MySQL/MariaDB (the configured connection), not SQLite.
