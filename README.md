# WebApp Kunjungan Sales

Aplikasi internal untuk mencatat kunjungan sales ke toko, mengelola stok barang, dan menghasilkan laporan penjualan. Dibangun untuk tim sales lapangan, admin gudang, dan owner distributor.

**Stack**: Laravel 13 + Laravel Breeze (Blade + Alpine.js) + Tailwind CSS + MySQL

---

## Fitur Utama

- **Stok Barang** — CRUD barang dengan tambah/kurang stok otomatis + histori pergerakan lengkap
- **Kategori Barang** — pengelompokan barang untuk filter & laporan
- **Toko** — data toko binaan per sales
- **Kunjungan** — sales mencatat kunjungan ke toko, opsional dengan transaksi barang; stok otomatis berkurang saat ada transaksi
- **Laporan Penjualan** — filter tanggal/toko/kategori/sales, export ke PDF & Excel
- **Manajemen User** — 3 role: Owner, Admin, Sales, dengan hak akses berbeda
- **Dashboard** — ringkasan statistik, chart penjualan, dan kunjungan terbaru (menyesuaikan role yang login)

## Role & Hak Akses

| Fitur | Owner | Admin | Sales |
|---|---|---|---|
| Stok Barang | Full CRUD + Adjust Stok | Full CRUD + Adjust Stok | Lihat + Histori saja |
| Kategori Barang | Full CRUD | Full CRUD | Lihat saja |
| Toko | Full CRUD | Full CRUD | Full CRUD |
| Kunjungan | Lihat semua | Lihat semua | Input baru + lihat milik sendiri |
| Laporan | Lihat semua | Lihat semua | Lihat milik sendiri |
| Manajemen User | Full (termasuk akun Owner lain) | Semua kecuali akun Owner | Tidak ada akses |

Data yang sudah punya histori transaksi (Toko/Barang/User dengan riwayat Kunjungan) **tidak bisa dihapus** untuk menjaga integritas laporan — ubah/nonaktifkan datanya saja jika diperlukan.

## Instalasi

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Set koneksi database di `.env` (default MySQL, database `kunjungan_sales`), lalu:

```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
npm run build
php artisan serve
```

Akun default dari seeder (password: `password`):
- `owner@kunjungansales.test` — Owner
- `admin@kunjungansales.test` — Admin
- `sales@kunjungansales.test` — Sales

## Development

```bash
npm run dev        # watch mode untuk Tailwind/Vite
php artisan serve  # jalankan server lokal
```

## Struktur Data Penting

- `stok_movements` — histori setiap perubahan stok (manual adjust maupun otomatis dari kunjungan)
- `kunjungans` + `kunjungan_details` — kunjungan bisa tanpa item (survei/follow-up); tiap item transaksi menyimpan **snapshot harga** saat itu supaya laporan lama tidak berubah walau harga barang di-update kemudian
- Semua aksi pengurangan stok tercatat via `StokMovement` dengan keterangan yang bisa ditelusuri ke kunjungan terkait

## Testing

Lihat `testing-checklist.md` untuk panduan testing manual end-to-end per role sebelum deploy.
