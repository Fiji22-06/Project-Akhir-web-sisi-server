# Sistem Manajemen Data Produk Toko

Website PHP Native untuk mengelola data produk toko dan menerima pesanan pelanggan. Project ini dibuat untuk tugas UAS dan siap dijalankan di localhost menggunakan XAMPP.

## Deskripsi Singkat

Project memiliki dua sisi tampilan:

- Sisi pelanggan untuk melihat produk, memasukkan produk ke keranjang, checkout, mencetak bukti pesanan, dan mengecek status pesanan.
- Sisi admin untuk login, mengelola pengguna, kategori, produk, pesanan, dan melihat statistik dashboard.

## Fitur Website

- Landing page pelanggan tanpa login.
- Daftar produk dengan search nama produk dan filter kategori.
- Detail produk dan tambah ke keranjang.
- Keranjang belanja menggunakan session.
- Checkout tanpa akun pelanggan.
- Bukti pesanan dengan tombol print.
- Cek pesanan menggunakan kode pesanan atau nomor HP.
- Login, daftar, akun, dan logout pelanggan pada sisi user.
- Riwayat pesanan pelanggan tampil di halaman Akun Saya setelah checkout.
- Bukti pesanan menampilkan konfirmasi bahwa pesanan sudah diterima sistem.
- Stok produk otomatis berkurang setelah checkout berhasil.
- Produk dengan stok habis otomatis disembunyikan dari katalog pelanggan.
- Login dan logout admin menggunakan session.
- Alert login gagal: `Username atau password salah`.
- Dashboard admin dengan statistik pengguna, kategori, produk, stok, pesanan, pendapatan, pesanan menunggu, dan pesanan selesai.
- CRUD Pengguna: tambah, tampil, edit, hapus.
- CRUD Kategori: tambah, tampil, edit, hapus.
- CRUD Produk: tambah, tampil, edit, hapus.
- Kelola Pesanan Admin: tampil, detail, ubah status, hapus.
- Password admin disimpan menggunakan `password_hash` dan dicek menggunakan `password_verify`.
- Tampilan responsif dengan Bootstrap 5, sidebar admin, navbar user, card, tabel, badge, dan alert.

## Struktur Folder

```text
manajemen_toko/
├── config/
│   └── database.php
├── auth/
│   ├── login.php
│   ├── proses_login.php
│   └── logout.php
├── pages/
│   ├── dashboard.php
│   ├── pengguna/
│   ├── kategori/
│   ├── produk/
│   └── pesanan/
├── user/
│   ├── index.php
│   ├── produk.php
│   ├── detail_produk.php
│   ├── keranjang.php
│   ├── tambah_keranjang.php
│   ├── update_keranjang.php
│   ├── hapus_keranjang.php
│   ├── checkout.php
│   ├── proses_checkout.php
│   ├── bukti_pesanan.php
│   ├── cek_pesanan.php
│   └── detail_pesanan.php
├── templates/
│   ├── header.php
│   ├── sidebar.php
│   ├── footer.php
│   ├── user_header.php
│   └── user_footer.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
├── database.sql
├── index.php
└── README.md
```

## Cara Import Database di phpMyAdmin

1. Jalankan Apache dan MySQL di XAMPP.
2. Buka browser lalu akses `http://localhost/phpmyadmin/`.
3. Pilih menu **Import**.
4. Klik **Choose File** dan pilih file `database.sql`.
5. Klik **Go** untuk menjalankan import database.

Database yang dibuat bernama `db_manajemen_toko` dan berisi tabel:

- `users`
- `kategori`
- `produk`
- `pesanan`
- `detail_pesanan`

## Cara Menjalankan Project di Localhost XAMPP

1. Copy folder `manajemen_toko` ke folder `htdocs`.
2. Jalankan Apache dan MySQL di XAMPP.
3. Buka phpMyAdmin.
4. Import file `database.sql`.
5. Akses halaman pelanggan:
   `http://localhost/manajemen_toko/user/`
6. Akses login admin:
   `http://localhost/manajemen_toko/auth/login.php`

Jika membuka `http://localhost/manajemen_toko/`, sistem akan otomatis mengarah ke halaman pelanggan.

## Akun Login Admin Default

- Username: `admin`
- Password: `admin123`

## Akun Login Pelanggan Default

- Username: `user`
- Password: `user123`

## Cara Menggunakan Keranjang

1. Buka halaman produk.
2. Klik tombol **Detail** untuk melihat detail produk atau klik **Tambah ke Keranjang**.
3. Buka menu **Keranjang**.
4. Ubah jumlah produk jika perlu.
5. Klik **Lanjut Checkout**.

## Cara Checkout

1. Pastikan keranjang tidak kosong.
2. Isi nama pelanggan, nomor HP, alamat lengkap, dan metode pembayaran.
3. Pilih metode pembayaran: `COD`, `Transfer Bank`, atau `E-Wallet`.
4. Klik **Buat Pesanan**.
5. Sistem akan membuat kode pesanan otomatis, contoh `ORD0001`.
6. Setelah checkout berhasil, halaman bukti pesanan akan tampil.

## Cara Cek Pesanan

1. Buka menu **Cek Pesanan**.
2. Masukkan kode pesanan atau nomor HP.
3. Klik **Cek Pesanan**.
4. Jika pesanan ditemukan, klik **Detail Pesanan** untuk melihat status dan daftar produk.

## Cara Admin Mengubah Status Pesanan

1. Login sebagai admin.
2. Buka menu **Pesanan**.
3. Klik tombol **Status** pada pesanan yang ingin diubah.
4. Pilih salah satu status:
   `Menunggu`, `Diproses`, `Selesai`, atau `Dibatalkan`.
5. Klik **Update Status**.
6. Pelanggan dapat melihat status terbaru melalui halaman **Cek Pesanan**.

## Konfigurasi Database

- Host: `localhost`
- Username: `root`
- Password: kosong
- Database: `db_manajemen_toko`
