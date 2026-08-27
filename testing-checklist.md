# Checklist Testing End-to-End — WebApp Kunjungan Sales

Jalankan `npm run build` dan `php artisan migrate` dulu sebelum mulai (kalau ada perubahan yang belum dijalankan).

## 1. Login & Akses Dasar
- [ ] `/` (root) redirect otomatis ke `/login`
- [ ] Login sebagai Owner, Admin, Sales — masing-masing masuk ke `/dashboard`
- [ ] Salah password → pesan error muncul, tidak nyasar ke halaman lain
- [ ] Klik nama user di sidebar → dropdown Profile/Log Out muncul di atas (tidak kepotong)
- [ ] Logout → balik ke halaman login

## 2. Dashboard (role-aware)
- [ ] Login **Sales** → stat "Toko Binaan"/"Kunjungan Bulan Ini"/dst hanya hitung data milik sales itu sendiri
- [ ] Login **Admin/Owner** → semua stat menghitung total keseluruhan (semua sales)
- [ ] Chart "Penjualan 14 Hari" & donut "Kategori" tampil sesuai data yang ada (kalau kosong, tampil pesan "belum ada data")
- [ ] Tabel "Kunjungan Terbaru" ke-klik → masuk ke halaman detail kunjungan yang benar

## 3. Stok Barang
- [ ] **Owner/Admin**: bisa Tambah, Edit, Hapus, Adjust Stok
- [ ] **Sales**: hanya bisa lihat index + Histori, tombol Tambah/Edit/Hapus/Adjust **tidak muncul**
- [ ] Sales coba akses langsung URL `/stok-barang/create` → dapat 403
- [ ] Adjust Stok "keluar" melebihi stok tersedia → ditolak dengan pesan error
- [ ] Hapus barang yang **sudah pernah** dipakai di Kunjungan → ditolak dengan pesan error (bukan malah kehapus)
- [ ] Cek Histori barang → semua pergerakan (stok awal, adjust manual, otomatis dari Kunjungan) tercatat lengkap

## 4. Kategori Barang
- [ ] **Owner/Admin**: full CRUD
- [ ] **Sales**: hanya lihat, tombol CRUD tidak muncul; akses langsung URL create/edit → 403
- [ ] Hapus kategori yang masih dipakai barang → ditolak

## 5. Toko
- [ ] Semua role (termasuk Sales) bisa Tambah/Edit/Hapus Toko
- [ ] Hapus toko yang **sudah punya histori Kunjungan** → ditolak dengan pesan error
- [ ] Filter by Sales berfungsi di index

## 6. Kunjungan
- [ ] **Sales**: bisa akses "+ Catat Kunjungan", submit tanpa item (survei) → berhasil tersimpan
- [ ] **Sales**: submit dengan beberapa item barang → stok otomatis berkurang, cek di Histori Stok Barang keterangannya "Kunjungan #ID"
- [ ] **Sales**: input jumlah melebihi stok tersedia → ditolak dengan pesan error, stok tidak berubah
- [ ] **Sales**: index kunjungan hanya menampilkan miliknya sendiri
- [ ] **Sales**: coba buka detail kunjungan milik sales lain (tebak URL `/kunjungan/{id}`) → 403
- [ ] **Admin/Owner**: tombol "+ Catat Kunjungan" **tidak muncul**; akses langsung URL create → 403
- [ ] **Admin/Owner**: index menampilkan semua kunjungan dari semua sales, filter by Sales & Toko berfungsi

## 7. Laporan
- [ ] **Sales**: laporan hanya tampilkan data miliknya, filter "Sales" tidak muncul di form
- [ ] **Admin/Owner**: laporan tampilkan semua data, bisa filter by Sales/Toko/Kategori/tanggal
- [ ] Export PDF → file terunduh, isinya sesuai filter yang aktif
- [ ] Export Excel → file terunduh (.xlsx), isinya sesuai filter yang aktif
- [ ] Summary "Total Item Terjual" & "Total Penjualan" akurat (coba hitung manual dari data kecil untuk verifikasi)

## 8. Manajemen User
- [ ] **Sales**: menu "Manajemen User" tidak muncul di sidebar; akses langsung URL `/users` → 403
- [ ] **Admin**: bisa kelola user role Admin & Sales, TAPI tidak bisa Edit/Hapus akun **Owner** (link disembunyikan + akses URL langsung → 403)
- [ ] **Owner**: bisa kelola semua user termasuk Owner lain
- [ ] Tidak ada yang bisa hapus akun **sendiri**
- [ ] Hapus user (Sales) yang **sudah punya histori Kunjungan** → ditolak dengan pesan error
- [ ] Buat user baru, password minimal sesuai aturan default Laravel → login pakai akun itu berhasil

## 9. Responsif / Mobile
- [ ] Buka di lebar layar sempit (resize browser / device toolbar) → sidebar berubah jadi drawer, tombol hamburger muncul di topbar
- [ ] Semua tabel besar (Kunjungan, Laporan) tetap bisa di-scroll horizontal di layar kecil tanpa merusak layout

## 10. Data Integrity (regresi)
- [ ] Buat Kunjungan baru dengan 2 barang berbeda → total di halaman detail = jumlah subtotal masing-masing barang
- [ ] Ubah harga barang di Stok Barang **setelah** ada histori kunjungan lama → detail kunjungan lama tetap pakai harga saat itu (snapshot), tidak ikut berubah
- [ ] Buat 2 kunjungan dengan barang yang sama secara berurutan → stok berkurang kumulatif dengan benar, tidak ada race condition/stok minus
