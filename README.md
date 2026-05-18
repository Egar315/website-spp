# Sistem Pembayaran SPP (SISP)

Sistem Informasi Pembayaran SPP (SISP) adalah aplikasi berbasis web yang dirancang untuk memudahkan pengelolaan, pencatatan, dan pembayaran Sumbangan Pembinaan Pendidikan (SPP) di sekolah. Aplikasi ini dibangun menggunakan framework Laravel dengan antarmuka yang modern, responsif, dan interaktif menggunakan Tailwind CSS v4.

## Fitur Utama

Aplikasi ini mendukung sistem otentikasi multi-peran (Multi-Role) dengan fitur-fitur yang disesuaikan untuk masing-masing pengguna:

### 1. Admin
- **Dashboard Analitik**: Ringkasan data siswa, petugas, dan total pembayaran.
- **Manajemen Pengguna**: CRUD (Create, Read, Update, Delete) untuk data petugas dan admin.
- **Manajemen Siswa**: CRUD data siswa yang komprehensif.
- **Manajemen Pembayaran**: Melihat dan mengelola seluruh riwayat transaksi pembayaran SPP.
- **Laporan**: Menghasilkan laporan pembayaran bulanan/tahunan.

### 2. Petugas (Staff)
- **Entri Pembayaran**: Mencatat pembayaran SPP dari siswa secara langsung, termasuk dukungan untuk pembayaran beberapa bulan sekaligus (bulk payment).
- **Riwayat Transaksi**: Melihat daftar pembayaran yang telah diproses.
- **Cetak Bukti**: Mengeluarkan struk atau bukti pembayaran untuk siswa.

### 3. Siswa (Student)
- **Dashboard Siswa**: Melihat status pembayaran (lunas/belum lunas) per bulan.
- **Riwayat Pembayaran**: Melacak histori pembayaran yang telah dilakukan.
- **Bukti Pembayaran**: Mengunduh atau mencetak bukti transaksi pembayaran yang sah.
- **Profil**: Melihat dan memperbarui data diri.

## Teknologi yang Digunakan

- **Backend**: Laravel (PHP)
- **Database**: SQLite (dapat disesuaikan dengan MySQL/PostgreSQL)
- **Frontend / UI**: Tailwind CSS v4
- **Desain UI/UX**: "Antigravity Premium" design system (Glassmorphism, animasi interaktif, desain responsif)

## Cara Instalasi & Menjalankan Secara Lokal

1. **Clone repositori ini:**
   ```bash
   git clone <URL_REPOSITORY>
   cd website-spp
   ```

2. **Install dependensi PHP (Composer):**
   ```bash
   composer install
   ```

3. **Install dependensi Node.js (NPM):**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env`
   ```bash
   cp .env.example .env
   ```
   *Atur konfigurasi database di file `.env` (secara default menggunakan SQLite).*

5. **Generate Application Key:**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database:**
   ```bash
   php artisan migrate --seed
   ```
   *(Gunakan flag `--seed` jika Anda ingin memasukkan data awal/dummy ke dalam database)*

7. **Jalankan Aplikasi:**
   Buka dua terminal terpisah untuk menjalankan server Laravel dan Vite (untuk kompilasi asset):
   
   Terminal 1 (Backend):
   ```bash
   php artisan serve
   ```
   
   Terminal 2 (Frontend):
   ```bash
   npm run dev
   ```

8. Buka browser dan akses `http://localhost:8000`
