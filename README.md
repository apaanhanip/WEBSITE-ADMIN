# SelfBrew Admin

Website admin fullstack untuk sistem pemesanan mandiri coffee shop (Self-Order Kiosk). Dibangun dengan **Laravel 10**, **MySQL**, **Tailwind CSS**, dan **Blade**.

## Fitur

- **Authentication Admin** — Login, logout, remember me, middleware auth
- **Dashboard** — Statistik, chart penjualan mingguan (Chart.js), pesanan terbaru
- **CRUD Kategori** — Search, pagination, validasi
- **CRUD Menu** — Upload gambar, preview, filter kategori, SweetAlert konfirmasi hapus
- **Manajemen Pesanan** — Update status realtime (AJAX), filter, modal detail
- **Manajemen Transaksi** — Filter tanggal, export PDF & Excel

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | Laravel 10, Eloquent ORM |
| Database | MySQL |
| Frontend | Blade, Tailwind CSS 3, Vite |
| Chart | Chart.js |
| Alert | SweetAlert2 |
| Export | DomPDF, Maatwebsite Excel |

## Persyaratan

- PHP >= 8.1
- Composer
- Node.js >= 18
- MySQL >= 5.7

## Instalasi

### 1. Clone & masuk folder project

```bash
cd selfbrew-admin
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Environment

```bash
copy .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="SelfBrew Admin"
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=selfbrew_admin
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat database MySQL

```sql
CREATE DATABASE selfbrew_admin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau import file `database/schema.sql`.

### 5. Migration & seeder

```bash
php artisan migrate --seed
php artisan storage:link
```

### 6. Build assets

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 7. Jalankan server

```bash
php artisan serve
```

Buka: **http://127.0.0.1:8000**

## Akun Demo

| Field | Value |
|-------|-------|
| Email | admin@selfbrew.coko |
| Password | password |

## Struktur Database

```
admins
categories ──< menus
orders ──< order_items >── menus
orders ──< transactions
```

## Routes Utama

| Method | URI | Keterangan |
|--------|-----|------------|
| GET | /login | Halaman login |
| GET | /dashboard | Dashboard admin |
| Resource | /categories | CRUD kategori |
| Resource | /menus | CRUD menu |
| GET | /orders | Manajemen pesanan |
| GET | /transactions | Riwayat transaksi |
| GET | /transactions-export/pdf | Export PDF |
| GET | /transactions-export/excel | Export Excel |

## Struktur Folder Penting

```
app/
├── Exports/TransactionsExport.php
├── Http/Controllers/
│   ├── Auth/LoginController.php
│   ├── CategoryController.php
│   ├── DashboardController.php
│   ├── MenuController.php
│   ├── OrderController.php
│   └── TransactionController.php
├── Http/Requests/
└── Models/

database/
├── migrations/
├── seeders/
├── factories/
└── schema.sql

resources/views/
├── layouts/
├── components/
├── auth/
├── dashboard/
├── categories/
├── menus/
├── orders/
└── transactions/
```

## License

MIT — Project TA Self-Order Kiosk Coffee Shop.
