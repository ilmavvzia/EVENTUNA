# EVENTUNA — Portal Informasi Event & Manajemen Poin SKP Mahasiswa
> Proyek Tugas Akhir Semester (UAS) Pemrograman Web — Berbasis **Laravel & Basis Data PostgreSQL (`pgsql`)**.

---

## 📌 IDENTITAS & PERAN KELOMPOK
- **Tema Proyek:** EVENTUNA (Portal Informasi Event Kampus & Manajemen Poin SKP Mahasiswa)
- **Role:** **ANGGOTA 1 (Ketua Kelompok)**
- **Tanggung Jawab Utama Anggota 1:**
  1. Pengelolaan Repository, Skema Basis Data PostgreSQL (`pgsql`), Primary & Foreign Key relasional, serta `DatabaseSeeder`.
  2. Implementasi Sistem Autentikasi & Role-Based Access Control (RBAC) 2-Level (`admin` & `ormawa`) menggunakan tabel terpisah `roles`, relasi `role_id`, helper `hasRole()`, dan proteksi server-side `RoleMiddleware` (403 Forbidden).
  3. Modul **Data Master 1 (M1 — Master Kategori Event)**: Resource Controller 7 aksi CRUD lengkap, pencarian `ILIKE` PostgreSQL, paginasi 10 baris, validasi server-side, dan proteksi penghapusan referensial.
  4. Modul **Transaksi 1 (T1 — Pengajuan/Publikasi Event Header-Detail)**: Relasi `events` (Header) dan `event_rundowns` (Detail Multi-baris), penyimpanan atomik via `DB::transaction()`, upload poster, generate slug otomatis, formulir dinamis JavaScript, serta tampilan publik.

---

## 🔑 DAFTAR AKUN SEEDER (DEMO APLIKASI)
Setelah menjalankan perintah migrasi dan seeding, sistem menyediakan akun bawaan berikut untuk pengujian:

| Role Pengguna | Email Login | Kata Sandi | Status Akun | Keterangan |
|---|---|---|:---:|---|
| **Super Admin** | `admin@eventuna.ac.id` | `password123` | `verified` | Akses penuh modul Admin (M1 Master Kategori Event, Data Master) |
| **Pengurus Ormawa** | `himti@vokasi.unair.ac.id` | `password123` | `verified` | Akun demo HIMTI D4 Teknik Informatika, Fakultas Vokasi |
| **Guest / Publik** | *(Tanpa Login)* | *(Tanpa Login)* | — | Akses publik katalog kegiatan & pendaftaran akun baru |

---

## ⚙️ PANDUAN INSTALASI & MIGRASI DATABASE (POSTGRESQL)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di lingkungan lokal:

### 1. Prasyarat Lingkungan
- PHP 8.2 atau lebih baru dengan ekstensi `pdo_pgsql` dan `pgsql` aktif.
- PostgreSQL Server 14+ (Port default: `5432`).
- Composer 2.x.

### 2. Konfigurasi Environment (`.env`)
Pastikan file `.env` di direktori root telah disesuaikan dengan kredensial PostgreSQL Anda:
```env
APP_NAME=EVENTUNA
APP_ENV=local
APP_KEY=base64:2qUBPUFZ6Dt7ANSX5pwtkShyYr0za5FcTYDtM3V5/ik=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Konfigurasi Wajib UAS: PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=eventuna
DB_USERNAME=postgres
DB_PASSWORD=password_postgres_anda
```

### 3. Eksekusi Migrasi & Seeding
Jalankan perintah berikut pada terminal:
```bash
# 1. Unduh pustaka dependensi
composer install

# 2. Buat symlink untuk berkas poster dan dokumen
php artisan storage:link

# 3. Jalankan migrasi seluruh tabel dan isi data awal seeder
php artisan migrate:fresh --seed

# 4. Jalankan server lokal
php artisan serve
```
Akses aplikasi melalui peramban web pada alamat: `http://localhost:8000`.

---

## 🛡️ MATRIKS HAK AKSES (RBAC) BAGIAN ANGGOTA 1
Setiap perutean dilindungi oleh middleware sisi server (`RoleMiddleware`). Jika peran pengguna tidak memenuhi kriteria, server akan mengembalikan respon **`403 Forbidden`**.

> **Keterangan Kode:**
> - `C` = Create (Menambah / Mengunggah data baru)
> - `R` = Read (Melihat / Membaca / Mencari data)
> - `U` = Update (Mengubah / Memperbarui data)
> - `D` = Delete (Menghapus data)
> - `-` = Ditolak / Tidak Memiliki Hak Akses

| No | Modul / Fitur / URL | Guest (Tanpa Login) | Ormawa (`ormawa`) | Super Admin (`admin`) | Keterangan & Lapisan Keamanan |
|:--:|---|:---:|:---:|:---:|---|
| **A** | **Autentikasi & Pengguna** | | | | |
| 1 | Halaman Utama Publik (`GET /`) | **R** | **R** | **R** | Terbaca untuk publik, menampilkan event `published`. |
| 2 | Detail & Rundown Event (`GET /event/{slug}`) | **R** | **R** | **R** | Menampilkan info event dan tabel detail rundown. |
| 3 | Form & Proses Daftar Ormawa (`/register-ormawa`) | **C, R** | **-** | **-** | Khusus calon pengurus ormawa baru. |
| 4 | Form Login Pengguna (`GET /login`) | **R** | **-** | **-** | Jika sudah login, otomatis diarahkan ke dashboard role. |
| 5 | Otentikasi Login (`POST /login`) | **C** | **-** | **-** | Validasi email & password, verifikasi status akun. |
| 6 | Keluar Sistem (`POST /logout`) | **-** | **C** | **C** | Menghapus sesi login dan regenerasi CSRF token. |
| **B** | **Data Master 1 (M1 — Master Kategori Event)** | | | | *Route::resource('admin/kategori')* |
| 7 | Tampil Daftar Kategori (`GET /admin/kategori`) | **-** (401/Login) | **-** (403 Forbidden) | **R** | Dilengkapi pagination 10 baris & penghitung relasi event. |
| 8 | Pencarian Kategori (`GET /admin/kategori?search=`) | **-** (401/Login) | **-** (403 Forbidden) | **R** | Query case-insensitive `ILIKE` pada PostgreSQL. |
| 9 | Form Tambah Kategori (`GET /admin/kategori/create`) | **-** (401/Login) | **-** (403 Forbidden) | **R** | Form input dengan color picker badge. |
| 10 | Simpan Kategori Baru (`POST /admin/kategori`) | **-** (401/Login) | **-** (403 Forbidden) | **C** | Validasi server-side: required, unique, max:50. |
| 11 | Detail Kategori (`GET /admin/kategori/{id}`) | **-** (401/Login) | **-** (403 Forbidden) | **R** | Menampilkan data kategori & event yang berelasi. |
| 12 | Form Edit Kategori (`GET /admin/kategori/{id}/edit`) | **-** (401/Login) | **-** (403 Forbidden) | **R** | Form pembaruan data kategori. |
| 13 | Perbarui Kategori (`PUT /admin/kategori/{id}`) | **-** (401/Login) | **-** (403 Forbidden) | **U** | Validasi server-side unik mengecualikan id saat ini. |
| 14 | Hapus Kategori (`DELETE /admin/kategori/{id}`) | **-** (401/Login) | **-** (403 Forbidden) | **D** | **Proteksi:** Ditolak jika kategori dipakai oleh tabel `events`. |
| **C** | **Transaksi 1 (T1 — Pengajuan Event Header-Detail)** | | | | *EventController (Header-Detail)* |
| 15 | Riwayat Event Ormawa (`GET /events`) | **-** (401/Login) | **R** | **-** (403 Forbidden) | Menampilkan event milik ormawa login & jumlah sesi. |
| 16 | Formulir Event Baru (`GET /events/create`) | **-** (401/Login) | **R** | **-** (403 Forbidden) | Form dinamis Header & multi-baris Detail Rundown. |
| 17 | Simpan Event & Rundown (`POST /events`) | **-** (401/Login) | **C** | **-** (403 Forbidden) | **Atomik:** Menggunakan `DB::transaction()` untuk header & detail. |
| 18 | Upload Poster Event | **-** (401/Login) | **C** | **-** (403 Forbidden) | Validasi gambar (JPG/PNG/WEBP, maks 2MB) ke storage publik. |
| 19 | Pembuatan Slug Unik Otomatis | **-** | **C** | **-** | Dihasilkan dari judul event + random string unik. |

---

## 🧩 LAPISAN ARSITEKTUR KODE (ANGGOTA 1)
- **Tabel & Migration:**
  - `roles`: `id`, `name` (unique), `label`, `timestamps`.
  - `users`: berelasi ke `roles` via `role_id` (foreign key restrict).
  - `master_kategori_event`: `id`, `nama_kategori` (unique), `warna_badge`, `timestamps`.
  - `events` (Header T1): `id`, `user_id`, `kategori_id`, `benefit_skp_id`, `judul_event`, `slug` (unique), `deskripsi`, `tanggal_mulai`, `tanggal_selesai`, `lokasi_atau_platform`, `link_pendaftaran`, `poster_path`, `status_publikasi`.
  - `event_rundowns` (Detail T1): `id`, `event_id` (foreign key cascade), `waktu_mulai`, `waktu_selesai`, `nama_sesi`, `pemateri_atau_pic`.
- **Model Eloquent:**
  - `Role` (`protected $fillable = ['name', 'label']`, relasi `hasMany` ke `User`).
  - `User` (`protected $fillable`, relasi `belongsTo` ke `Role`, helper `hasRole(string|array)`).
  - `MasterKategoriEvent` (`protected $fillable = ['nama_kategori', 'warna_badge']`, relasi `hasMany` ke `Event`).
  - `Event` (`protected $fillable`, relasi `belongsTo` ke `User`, `MasterKategoriEvent`, `MasterBenefitSkp`, serta `hasMany` ke `EventRundown`).
  - `EventRundown` (`protected $fillable`, relasi `belongsTo` ke `Event`).
- **Middleware Keamanan:**
  - `RoleMiddleware` terdaftar di `bootstrap/app.php` dengan alias `'role'`.
- **Controller:**
  - `LoginController`: login, logout, storeRegister, role redirection.
  - `Admin\MasterKategoriController`: 7 aksi Resource Controller M1.
  - `EventController`: publicIndex, publicShow, index (Ormawa), create, store (DB transaction atomik).
- **Blade Views (`@extends('layouts.app')`):**
  - `resources/views/layouts/app.blade.php`: Layout induk dengan navbar responsif dinamis role.
  - `resources/views/welcome.blade.php`: Katalog event publik.
  - `resources/views/events/public-show.blade.php`: Halaman detail event & tabel rundown.
  - `resources/views/events/index.blade.php`: Daftar event milik Ormawa.
  - `resources/views/events/create.blade.php`: Form multi-baris dinamis Rundown.
  - `resources/views/admin/kategori/index.blade.php`: Manajemen data master kategori M1.
  - `resources/views/admin/kategori/create.blade.php`: Form tambah kategori.
  - `resources/views/admin/kategori/edit.blade.php`: Form edit kategori.
  - `resources/views/admin/kategori/show.blade.php`: Detail kategori & daftar event terikat.
