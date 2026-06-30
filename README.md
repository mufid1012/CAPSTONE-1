# Sistem Informasi Administrasi PPTQ Ibnu Juraimi

Sebuah platform berbasis web komprehensif yang dirancang untuk mengelola dan memantau kegiatan akademik serta non-akademik di Pondok Pesantren Tahfidzul Qur'an (PPTQ) Ibnu Juraimi. Sistem ini menghubungkan tiga pilar utama pesantren: **Pengurus (Admin)**, **Pengajar (Ustadz)**, dan **Orang Tua (Wali Murid)**.

---

## ✨ Fitur Utama

### 👑 1. Modul Admin (Pengelola)
* **Manajemen Data Master**: Pengelolaan data Santri (Berdasarkan jenjang Tsanawiyah, Aliyah, dan Takhassus), Ustadz, Wali Murid, dan Kegiatan Pondok.
* **Manajemen Penugasan**: Mengatur plot ustadz pada kegiatan tertentu serta menentukan Santri Binaan untuk setiap ustadz.
* **Sistem Laporan Global**: Memantau operasional pesantren melalui menu laporan dengan filter terperinci (berdasarkan bulan, tingkatan, kelas, ustadz):
  * **Laporan Presensi Ustadz**
  * **Laporan Presensi Santri**
  * **Laporan Setoran Hafalan**
  * **Laporan Murojaah**

### 👳‍♂️ 2. Modul Ustadz (Pengajar)
* **Presensi Geolocation**: Absensi ustadz yang terintegrasi dengan validasi jarak radius koordinat pesantren (dapat dikonfigurasi).
* **Manajemen Kegiatan**: Mencatat presensi santri di kegiatan yang diampu.
* **Manajemen Al-Qur'an**: Menginput secara spesifik (Juz, Surat, Ayat) nilai Setoran Hafalan dan Murojaah bagi santri binaannya.

### 👨‍👩‍👧 3. Modul Wali Murid (Orang Tua)
* **Dashboard Monitoring**: Memantau progres anak (Santri) secara *real-time* dari rumah.
* **Riwayat Presensi & Akademik**: Mengetahui apakah santri hadir dalam kegiatan pondok serta melihat histori capaian hafalan dan murojaah.

---

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel 11](https://laravel.com/) (PHP)
* **Frontend:** [Tailwind CSS](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/) (TALL Stack minimalis tanpa Livewire)
* **Database:** SQLite (Bawaan) / MySQL / PostgreSQL
* **Autentikasi & Otorisasi:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
* **Pengujian (Testing):** PHPUnit & Laravel Feature Tests

---

## 🚀 Panduan Instalasi (Lokal)

1. **Clone repositori ini:**
   ```bash
   git clone https://github.com/username/pptq-system.git
   cd pptq-system
   ```

2. **Instalasi dependensi PHP & Node.js:**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Konfigurasi Environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrasi dan *Seeding* Database:**
   Proses ini akan otomatis membuat tabel, hak akses, akun demo, serta ratusan *dummy data* (riwayat hafalan, murojaah, dan presensi).
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan *Development Server*:**
   ```bash
   php artisan serve
   ```
   Akses di browser melalui `http://localhost:8000`

---

## 🧪 Akun Demo (Testing)

Gunakan kredensial berikut untuk menguji coba fitur dalam sistem (Password untuk semua akun di bawah adalah `password`):

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@pptq.test` | `password` |
| **Ustadz** | `ustadz1@pptq.test` (hingga `ustadz5`) | `password` |
| **Wali Murid** | `wali1@pptq.test` (hingga `wali8`) | `password` |

---

## 🌍 Panduan Deployment (Vercel)

Karena aplikasi ini menggunakan Laravel, *deployment* ke serverless Vercel memerlukan beberapa penyesuaian khusus (seperti menggunakan `vercel-php`).

1. Pastikan Anda mengatur Environment Variables (`APP_KEY`, `DB_CONNECTION`, dll) di dashboard Vercel.
2. Jika menggunakan Vercel, SQLite tidak direkomendasikan karena bersifat *serverless/ephemeral* (data akan hilang saat *instance hibernate*). Disarankan untuk menggunakan Database Cloud gratis seperti **Supabase (PostgreSQL)**, **Neon**, atau **PlanetScale (MySQL)** untuk database *production*.
3. Sesuaikan folder `public` sebagai letak *entry point* dari Vercel.

---

*Dibuat untuk keperluan Tugas Akhir / Capstone Project.*
