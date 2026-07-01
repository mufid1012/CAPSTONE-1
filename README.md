# Sistem Informasi Administrasi PPTQ Ibnu Juraimi

Sebuah platform berbasis web komprehensif yang dirancang untuk mengelola dan memantau kegiatan akademik serta non-akademik di Pondok Pesantren Tahfidzul Qur'an (PPTQ) Ibnu Juraimi. Sistem ini menghubungkan tiga pilar utama pesantren: **Pengurus (Admin)**, **Pengajar (Ustadz)**, dan **Orang Tua (Wali Murid)**.

---

## ✨ Fitur Utama

### 👑 1. Modul Admin (Pengelola)
* **Manajemen Data Master**: Pengelolaan data Santri (berdasarkan jenjang Tsanawiyah, Aliyah, dan Takhassus serta per kelas), Ustadz, Wali Murid, dan Kegiatan Pondok.
* **Manajemen Penugasan**: Mengatur plot ustadz pada kegiatan tertentu (dengan filter tingkatan & kelas) serta menentukan Santri Binaan untuk setiap ustadz.
* **Sistem Laporan Global**: Memantau operasional pesantren melalui menu laporan dengan filter terperinci (berdasarkan bulan, tingkatan, kelas, ustadz):
  * **Laporan Presensi Ustadz**
  * **Laporan Presensi Santri**
  * **Laporan Setoran Hafalan**
  * **Laporan Murojaah**

### 👳‍♂️ 2. Modul Ustadz (Pengajar)
* **Presensi Geolocation**: Absensi ustadz yang terintegrasi dengan validasi koordinat lokasi pesantren.
* **Manajemen Kegiatan**: Mencatat presensi santri di kegiatan yang diampu, dengan daftar santri otomatis tersaring sesuai tingkatan dan kelas kegiatan.
* **Manajemen Al-Qur'an**: Menginput secara spesifik (Juz, Surat, Ayat) nilai Setoran Hafalan dan Murojaah bagi santri binaannya.

### 👨‍👩‍👧 3. Modul Wali Murid (Orang Tua)
* **Dashboard Monitoring**: Memantau progres anak (Santri) secara *real-time* dari rumah.
* **Riwayat Presensi & Akademik**: Mengetahui kehadiran santri dalam kegiatan pondok serta melihat histori capaian hafalan dan murojaah.

---

## 🛠️ Teknologi yang Digunakan

* **Framework:** [Laravel 11](https://laravel.com/) (PHP)
* **Frontend:** [Tailwind CSS](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/)
* **Database:** SQLite (Development) / PostgreSQL (Production)
* **Autentikasi & Otorisasi:** [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
* **Pengujian:** PHPUnit & Laravel Feature Tests

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
   Proses ini akan otomatis membuat tabel, hak akses, akun demo, serta data contoh (riwayat hafalan, murojaah, dan presensi selama 45 hari).
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Jalankan *Development Server*:**
   ```bash
   php artisan serve
   ```
   Akses di browser melalui `http://localhost:8000`

---

## 🧪 Akun Demo

Gunakan kredensial berikut untuk menguji coba fitur dalam sistem (Password: `password`):

| Role | Email | Nama |
| :--- | :--- | :--- |
| **Admin** | `admin@pptq.test` | Administrator |
| **Ustadz** | `ustadz1@pptq.test` | Ustadz Abdullah Faqih |
| **Ustadz** | `ustadz2@pptq.test` | Ustadz Muhammad Ridwan |
| **Ustadz** | `ustadz3@pptq.test` | Ustadz Hasan Al-Basri |
| **Ustadz** | `ustadz4@pptq.test` | Ustadz Imam Syafi'i |
| **Ustadz** | `ustadz5@pptq.test` | Ustadz Zainul Arifin |
| **Wali Murid** | `wali1@pptq.test` | Bapak Ahmad Sulaiman |
| **Wali Murid** | `wali2@pptq.test` | Ibu Siti Aminah |

> Password untuk semua akun: `password`

---

## 📊 Data Contoh

Setelah menjalankan `migrate:fresh --seed`, sistem akan terisi data berikut:

* **5 Ustadz** dengan penugasan kegiatan dan santri binaan
* **8 Wali Murid** yang terhubung dengan santri
* **24 Santri** tersebar di 3 jenjang:
  * Tsanawiyah: Kelas 7 (4 santri), Kelas 8 (3 santri), Kelas 9 (3 santri)
  * Aliyah: Kelas 10 (3 santri), Kelas 11 (3 santri), Kelas 12 (3 santri)
  * Takhassus: 5 santri
* **11 Kegiatan Pondok** dengan spesifikasi per tingkatan dan kelas
* **Riwayat 45 hari** presensi, setoran hafalan, dan murojaah menggunakan nama surat Al-Qur'an yang sesungguhnya

---

## 🌍 Deployment (Vercel + Supabase)

1. Push repositori ke GitHub
2. Import project di [Vercel](https://vercel.com/)
3. Buat database PostgreSQL di [Supabase](https://supabase.com/)
4. Atur Environment Variables di Vercel:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=<host-supabase>
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=<username-supabase>
   DB_PASSWORD=<password-supabase>
   APP_KEY=<copy-dari-env-lokal>
   APP_URL=https://<domain-vercel>.vercel.app
   SESSION_DRIVER=cookie
   CACHE_STORE=array
   LOG_CHANNEL=stderr
   ```
5. Jalankan migrasi dari lokal ke Supabase:
   ```bash
   php artisan migrate:fresh --seed
   ```

---

*Dibuat untuk keperluan Tugas Akhir / Capstone Project.*
