# BizzMap — Project Brief untuk Claude Code

## Ringkasan Proyek
Aplikasi web berbasis Laravel untuk pemetaan pelanggan (Indibiz) dan
non-pelanggan Telkom Kota Jambi. Sales/AR menginput lokasi bisnis ke
peta, admin memverifikasi, lalu data tampil sebagai marker di peta
Leaflet.js. Dibuat sebagai skripsi dengan metode Extreme Programming.

## Tech Stack
- Framework  : Laravel 11 (PHP 8.2)
- Frontend   : Blade template, Bootstrap 5.3, Leaflet.js, Chart.js
- Database   : MySQL (dikelola via phpMyAdmin)
- Auth       : Laravel built-in session auth
- CI/CD      : GitHub Actions
- IDE        : Visual Studio Code

## Struktur Role User
| Role  | Akses                                              |
|-------|----------------------------------------------------|
| admin | Verifikasi data, kelola user, lihat semua lokasi   |
| user  | Input data lokasi (sales / SA / AR)                |

## Alur Data Utama
1. User (sales) klik peta → isi form → POST /locations
2. Data masuk DB dengan status = pending
3. Admin buka /admin/pending → approve atau reject
4. Jika approved → status = approved → marker muncul di peta

## Halaman yang Ada
| URL                  | File View                        | Keterangan              |
|----------------------|----------------------------------|-------------------------|
| /                    | landing.blade.php                | Landing page            |
| /login               | login.blade.php                  | Login                   |
| /register            | register.blade.php               | Register                |
| /menu                | menu.blade.php                   | Menu utama setelah login|
| /geo                 | geo.blade.php                    | Peta utama (Leaflet)    |
| /demografi           | demografi.blade.php              | Chart demografi         |
| /analytics           | analytics.blade.php              | Analytics per segmen    |
| /admin               | admin/dashboard.blade.php        | Dashboard admin         |
| /admin/pending       | admin/pending.blade.php          | Verifikasi data         |
| /admin/users         | admin/users.blade.php            | Kelola user             |
| /admin/locations     | admin/locations.blade.php        | Kelola semua lokasi     |

## Controller Utama
- UserController     → login, logout, register
- LocationController → store(), approved(), import(), demografi(), analytics()
- AdminController    → dashboard, pending, approve, reject, users, locations

## Struktur Tabel Database
### Tabel: locations (tabel utama)
| Kolom      | Tipe                                                  | Keterangan           |
|------------|-------------------------------------------------------|----------------------|
| id         | bigint PK                                             |                      |
| user_id    | FK → users.id                                         | Siapa yang input     |
| name       | varchar(150)                                          | Nama bisnis          |
| address    | text                                                  | Alamat               |
| latitude   | double                                                |                      |
| longitude  | double                                                |                      |
| type       | enum: customer, non_customer                          |                      |
| segment    | enum: sekolah,ruko,hotel,multifinance,health,ekspedisi,energi |            |
| status     | enum: pending, approved                               | Default: pending     |
| created_at | timestamp                                             |                      |
| updated_at | timestamp                                             |                      |

### Tabel: users
| Kolom    | Tipe                    | Keterangan          |
|----------|-------------------------|---------------------|
| id       | bigint PK               |                     |
| name     | varchar                 |                     |
| email    | varchar unique          |                     |
| password | varchar                 |                     |
| role     | enum: admin, user       | Default: user       |

## Konvensi Wajib Diikuti
- JANGAN edit file migration lama — selalu buat migration baru
- Semua kolom baru di tabel locations harus nullable (data lama tidak rusak)
- Warna utama CSS: #C02016 (merah Telkom), font: Poppins
- Setiap fitur baru di controller harus ada validasi request
- Nama method di controller ikut konvensi yang sudah ada (camelCase)
- Enum omset: di_bawah_5jt | 5jt_20jt | 20jt_50jt | 50jt_100jt | di_atas_100jt

## Yang JANGAN Dilakukan
- Jangan hapus atau overwrite migration lama
- Jangan ubah struktur kolom yang sudah ada (type, segment, status)
- Jangan ganti library Leaflet atau Chart.js yang sudah terpasang
- Jangan ubah sistem auth yang sudah berjalan

---

## Roadmap Pengembangan

### ✅ Sudah Selesai (Iterasi 1 & 2)
- [x] Autentikasi (login, logout, register)
- [x] Peta Leaflet dengan marker customer & non-customer
- [x] Form input data lokasi
- [x] Upload & download CSV
- [x] Sistem pending → approved (verifikasi admin)
- [x] Halaman demografi (pie chart per segmen & tipe)
- [x] Halaman analytics per segmen
- [x] Admin: kelola user, kelola lokasi, filter & search
- [x] Black box testing iterasi 1 & 2
- [x] CI/CD dengan GitHub Actions

### 🔴 Prioritas 1 — Fondasi Data (Kerjakan Duluan)
- [ ] P1A: Tambah field baru di tabel locations:
        owner_name, phone, business_detail, omset, paket_langganan
        (migration baru + update Model, Controller, Form geo.blade.php,
        form edit admin, popup marker)
- [ ] P1B: Pencegahan data duplikat
        (cek nama bisnis + radius koordinat < 50m, warning popup frontend,
        validasi backend)

### 🟡 Prioritas 2 — Tracking & History
- [ ] P2A: Buat tabel location_histories
        (location_id, changed_by user_id, old_status, new_status, timestamp)
        Trigger: setiap approve / reject / edit status oleh admin
- [ ] P2B: Dashboard perubahan status bulanan
        (chart di halaman demografi: berapa non-customer → customer per bulan)

### 🟢 Prioritas 3 — Analisis Lebih Kaya
- [ ] P3A: Flag non-customer potensial (field is_potential + marker warna beda)
- [ ] P3B: Demografi multi-dimensi (filter omset, paket, bidang bisnis)
- [ ] P3C: Auto-rekomendasi teks di halaman analytics berdasarkan jumlah data

### 🔵 Prioritas 4 — Output & Pengujian
- [ ] P4A: Export laporan PDF / Excel per periode
- [ ] P4B: Load testing dengan JMeter (response time, throughput, error rate)

---

## Cara Update File Ini
Setiap kali sebuah fitur selesai dikerjakan, ubah [ ] menjadi [x]
pada checklist di atas. Lakukan ini di akhir setiap sesi pengerjaan.

## Perintah Berguna
```bash
# Jalankan server lokal
php artisan serve

# Buat migration baru
php artisan make:migration nama_migration

# Jalankan migration
php artisan migrate

# Rollback migration terakhir
php artisan migrate:rollback

# Buka tinker (debug DB)
php artisan tinker

# Clear cache
php artisan config:clear && php artisan cache:clear
```