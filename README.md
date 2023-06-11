# Panduan Instalasi Proyek Pemesanan Kendaraan

Sebuah aplikasi berbasis Laravel untuk mengelola pemesanan kendaraan suatu perusahaan.

## Daftar Isi
- [Prasyarat](#prasyarat)
- [Langkah-langkah Instalasi](#langkah-langkah-instalasi)
- [Akun](#akun)

## Prasyarat

Sebelum memulai instalasi, pastikan Anda telah memenuhi prasyarat berikut:

1. PHP 8.0
2. Composer 2.4
3. Laravel 9
3. MySQL 10
4. Git

## Langkah-langkah Instalasi

Berikut adalah langkah-langkah untuk menginstal proyek Penjualan Kendaraan REST API Laravel:

1. Clone Repositori

   Buka terminal atau command prompt dan jalankan perintah berikut untuk mengkloning repositori:

   ```bash
   git clone https://github.com/shofistwn/pemesanan-kendaraan.git
   ```

2. Pindah ke Direktori Proyek

   Masuk ke direktori proyek yang telah di-kloning dengan menjalankan perintah:

   ```bash
   cd pemesanan-kendaraan
   ```

3. Instal Dependensi

   Jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan oleh proyek:

   ```bash
   composer install
   ```

4. Konfigurasi Lingkungan

   Salin file `.env.example` menjadi `.env` dengan menjalankan perintah:

   ```bash
   cp .env.example .env
   ```

5. Generate Kunci Aplikasi

   Jalankan perintah berikut untuk menghasilkan kunci aplikasi:

   ```bash
   php artisan key:generate
   ```

6. Konfigurasi Database

   Buka file `.env` dan ubah pengaturan database seperti berikut:

   ```bash
    DB_CONNECTION=mongodb
    DB_HOST=127.0.0.1
    DB_PORT=27017
    DB_DATABASE=pemesanan_kendaraan
    DB_USERNAME=
    DB_PASSWORD=
   ```

7. Mengimpor Database

    Import file database yang berada di `/documents/dump.sql`
    
8. Jalankan Server Lokal

   Terakhir, jalankan server lokal dengan perintah:

   ```bash
   php artisan serve
   ```

   Server akan berjalan di `http://localhost:8000`.

## Akun

1.  Admin

    ```
    email       : admin@mail.com
    password    : password
    ```

2.  Regional Manager (Pihak 1)

    ```
    email       : regional@mail.com
    password    : password
    ```

3.  Branch Manager (Pihak 2)

    ```
    email       : branch@mail.com
    password    : password
    ```
    
Password untuk semua akun sama, yaitu `password`