# 📸 LensArt - Sistem Informasi Reservasi Studio Foto Berbasis Website

LensArt adalah sistem informasi reservasi studio foto berbasis website yang dibuat untuk membantu proses reservasi pelanggan di Studio LensArt. Melalui sistem ini, customer dapat melakukan reservasi secara online, memilih paket foto, menentukan jadwal pemotretan, melakukan pembayaran melalui QRIS, serta mengunggah bukti pembayaran.

Sistem ini juga menyediakan halaman owner untuk mengelola data reservasi, melihat detail booking, memverifikasi pembayaran customer, serta memantau data reservasi melalui dashboard.

Dibuat oleh: **Citra Dwi Lestari**
NIM: **242410101009**
Program Studi: **Sistem Informasi**
Fakultas Ilmu Komputer - Universitas Jember

Deploy Website: http://studiolens-art.my.id/

---

## ✨ Fitur Utama

Aplikasi LensArt memiliki dua jenis pengguna, yaitu **Customer** dan **Owner**.

### Fitur Customer

* Registrasi akun customer.
* Login dan logout akun.
* Melihat dashboard customer.
* Melihat informasi paket foto.
* Melakukan reservasi studio foto.
* Melihat riwayat reservasi pribadi.
* Melihat status pembayaran.
* Mengelola profil customer.
* Mengatur preferensi tampilan website, seperti mode terang dan mode gelap.
* Melihat informasi cuaca sebelum melakukan reservasi.

### Fitur Owner

* Login dan logout sebagai owner.
* Melihat dashboard owner.
* Melihat statistik reservasi.
* Melihat daftar seluruh reservasi customer.
* Melakukan pencarian reservasi secara dinamis.
* Menambahkan reservasi secara manual.
* Mengedit data reservasi.
* Menghapus data reservasi.
* Melihat detail reservasi.
* Melihat bukti pembayaran customer.
* Menandai pembayaran sebagai lunas.
* Menolak pembayaran jika bukti tidak sesuai.
* Mengelola profil owner.

---

## 🛠️ Teknologi yang Digunakan

Sistem LensArt dibangun menggunakan beberapa teknologi berikut:

* **HTML**: digunakan untuk menyusun struktur halaman website.
* **CSS**: digunakan untuk mengatur tampilan website, layout, warna, card, tabel, tombol, dan dark mode.
* **JavaScript**: digunakan untuk membuat halaman lebih interaktif, seperti preview harga otomatis, filter reservasi, pengaturan slot jam, dan toggle mode.
* **Fetch API / AJAX**: digunakan untuk fitur pencarian reservasi secara dinamis tanpa reload halaman.
* **PHP**: digunakan sebagai bahasa pemrograman server-side.
* **Laravel**: digunakan sebagai framework utama untuk routing, controller, model, middleware, validasi, autentikasi, dan database.
* **Blade Template**: digunakan untuk membuat tampilan halaman Laravel secara dinamis.
* **MySQL**: digunakan sebagai database untuk menyimpan data user, reservasi, jadwal, paket, harga, dan pembayaran.
* **Session**: digunakan untuk login, logout, pembatasan akses, role user, dan session counter.
* **Cookies**: digunakan untuk menyimpan preferensi tampilan seperti mode terang/gelap dan ukuran font.
* **GitHub**: digunakan sebagai repository penyimpanan source code project.

---

## 🗂️ Struktur Database

Database utama yang digunakan adalah **MySQL** dengan beberapa tabel penting berikut:

1. **users**
   Menyimpan data akun pengguna, baik owner maupun customer.

2. **reservasis**
   Menyimpan data reservasi, seperti kode booking, nama pelanggan, email, nomor HP, paket foto, harga, tanggal, jam, metode pembayaran, status pembayaran, dan bukti pembayaran.

3. **profil_owners**
   Menyimpan data profil owner atau informasi studio.

4. **layanan_tambahans**
   Menyimpan data layanan tambahan.

5. **layanan_reservasi**
   Menyimpan relasi antara reservasi dan layanan tambahan.

Tabel pendukung Laravel seperti `sessions`, `cache`, `cache_locks`, `password_reset_tokens`, dan `migrations` digunakan untuk kebutuhan teknis sistem.

---

## 💳 Status Pembayaran

Sistem LensArt menggunakan beberapa status pembayaran:

* **Belum Bayar**: customer sudah membuat reservasi, tetapi belum mengunggah bukti pembayaran.
* **Menunggu Verifikasi**: customer sudah mengunggah bukti pembayaran dan menunggu pengecekan owner.
* **Lunas**: pembayaran sudah disetujui oleh owner.
* **Ditolak**: bukti pembayaran ditolak oleh owner.

Reservasi yang dibuat oleh owner secara manual akan otomatis memiliki status pembayaran **Lunas**.

---

## ⏰ Sistem Slot Reservasi

Sistem menggunakan slot jadwal per 30 menit. Customer dapat memilih tanggal dan jam reservasi yang tersedia.

Jika suatu tanggal dan jam sudah dibooking oleh customer lain, maka slot tersebut tidak dapat dipilih kembali. Fitur ini digunakan untuk mencegah jadwal pemotretan bertabrakan.

---

## 📡 Implementasi AJAX

Fitur AJAX diterapkan pada halaman manajemen reservasi owner.

Owner dapat mencari data reservasi berdasarkan nama, email, kode booking, paket foto, tanggal, atau status pembayaran. Pencarian dilakukan menggunakan **Fetch API** dan data dikembalikan dalam format **JSON**, sehingga tabel reservasi dapat diperbarui tanpa reload halaman penuh.

---

## 🍪 Implementasi Session dan Cookies

### Session

Session digunakan untuk:

* Menyimpan status login pengguna.
* Mengatur akses halaman berdasarkan role owner dan customer.
* Menangani proses logout.
* Menampilkan session counter pada dashboard customer.

### Cookies

Cookies digunakan untuk:

* Menyimpan preferensi mode terang dan mode gelap.
* Menyimpan preferensi ukuran font.
* Menyimpan data kunjungan dashboard customer agar tetap tersimpan setelah logout dan login kembali.

---

## 🚀 Cara Instalasi dan Menjalankan Aplikasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan project LensArt di komputer/laptop.

### 1. Persyaratan Sistem

Pastikan sudah menginstal:

* PHP minimal versi 8.2
* Composer
* Node.js dan NPM
* MySQL
* XAMPP atau Laragon
* Git
* Browser seperti Chrome atau Edge

---

### 2. Clone Repository

```bash
git clone <URL_REPOSITORY_GITHUB_ANDA>
cd <NAMA_FOLDER_PROJECT>
```

Contoh:

```bash
git clone https://github.com/username/lensart.git
cd lensart
```

---

### 3. Install Dependency Laravel

```bash
composer install
```

---

### 4. Install Dependency Frontend

```bash
npm install
```

---

### 5. Salin File Environment

```bash
cp .env.example .env
```

Jika menggunakan Windows dan perintah tersebut tidak bisa, salin file `.env.example` secara manual lalu ubah namanya menjadi `.env`.

---

### 6. Generate Application Key

```bash
php artisan key:generate
```

---

### 7. Konfigurasi Database

Buat database baru di phpMyAdmin dengan nama:

```text
lensart_db
```

Lalu sesuaikan file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lensart_db
DB_USERNAME=root
DB_PASSWORD=
```

Tambahkan juga timezone:

```env
APP_TIMEZONE=Asia/Jakarta
```

Jika tidak menggunakan queue database, gunakan:

```env
QUEUE_CONNECTION=sync
```

---

### 8. Jalankan Migration

```bash
php artisan migrate
```

---

### 9. Buat Storage Link

```bash
php artisan storage:link
```

Perintah ini digunakan agar file upload, seperti bukti pembayaran, dapat ditampilkan melalui folder public.

---

### 10. Jalankan Asset Frontend

```bash
npm run dev
```

Biarkan terminal ini tetap berjalan.

---

### 11. Jalankan Server Laravel

Buka terminal baru, lalu jalankan:

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## 🔐 Akun Default untuk Uji Coba

Gunakan akun berikut untuk mencoba sistem.

### Owner

```text
Email    : owner@gmail.com
Password : owner123
```

### Customer

```text
Email    : citraadwii002@gmail.com
Password : citra123
```

Jika akun belum tersedia, pengguna dapat melakukan register terlebih dahulu atau membuat akun melalui database/seeder.

---

## 🧪 Alur Penggunaan Aplikasi

### Alur Customer

1. Buka halaman utama LensArt.
2. Register atau login sebagai customer.
3. Masuk ke dashboard customer.
4. Pilih menu Reservasi.
5. Buat reservasi baru.
6. Pilih paket foto, tanggal, dan jam pemotretan.
7. Sistem menampilkan harga otomatis.
8. Sistem mencegah pemilihan slot yang sudah dibooking.
9. Customer diarahkan ke halaman pembayaran QRIS.
10. Customer mengunggah bukti pembayaran.
11. Customer menunggu verifikasi pembayaran dari owner.

### Alur Owner

1. Login sebagai owner.
2. Masuk ke dashboard owner.
3. Melihat statistik reservasi.
4. Membuka menu Reservasi.
5. Melakukan pencarian data reservasi menggunakan live search.
6. Membuka detail reservasi.
7. Memeriksa bukti pembayaran.
8. Menandai pembayaran sebagai lunas atau ditolak.
9. Menambah, mengedit, atau menghapus data reservasi jika diperlukan.

---

## 🔮 Pengembangan Selanjutnya

Beberapa pengembangan yang dapat dilakukan pada versi berikutnya:

* Integrasi payment gateway otomatis.
* Cetak invoice atau bukti reservasi.
* Export laporan reservasi.
* Grafik pendapatan studio.
* Pengembangan aplikasi versi mobile.

---
