# AGENTS.md

## Cursor Cloud specific instructions

SelfBrew Admin is a single Laravel 10 monolith (PHP backend + Blade/Tailwind/Vite frontend) for a coffee-shop self-order kiosk admin panel. Standard setup/run/test commands live in `README.md`; only non-obvious caveats are captured here.

### Services
- **Laravel app server** (required): `php artisan serve --host=0.0.0.0 --port=8000`. Root `/` redirects to `/login`.
- **Vite dev server** (required for styled pages): `npm run dev`. The `@vite` Blade directive needs either this running OR pre-built assets (`npm run build`). It writes `public/hot` while running; pages reference assets from `http://[::1]:5173`.
- **MySQL** (required): start with `sudo service mysql start` (it is NOT auto-started on boot).

### Database / auth caveat
- The app connects over TCP as `root` with an empty password (see `.env`). Ubuntu's default `root@localhost` uses `auth_socket`, so a dedicated `root@127.0.0.1` user with `mysql_native_password` and empty password was created during setup. Databases `selfbrew_admin` (app) and `selfbrew_admin_test` exist. If a fresh VM lacks these, recreate via `sudo mysql`.
- After starting MySQL, apply schema with `php artisan migrate --seed` if the DB is empty.

### Demo login
- Email `admin@selfbrew.coko`, password `password` (seeded by `AdminSeeder`). Guard is `admin` (not the default `web`).

### Lint / Test notes
- Lint: `./vendor/bin/pint` (format) or `./vendor/bin/pint --test` (check). `--test` reports pre-existing style issues in default Laravel scaffolding files; these are not introduced by changes.
- Tests: `php artisan test`. `Tests\Feature\ExampleTest` fails by default because it asserts `/` returns 200, but `/` redirects (302) to login — this is a pre-existing default-scaffold mismatch, not an environment problem. Tests run against the MySQL connection (the SQLite line in `phpunit.xml` is commented out).
