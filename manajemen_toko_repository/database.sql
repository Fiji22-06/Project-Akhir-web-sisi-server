CREATE DATABASE IF NOT EXISTS db_manajemen_toko
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE db_manajemen_toko;

DROP TABLE IF EXISTS detail_pesanan;
DROP TABLE IF EXISTS pesanan;
DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(150) NOT NULL,
    kategori_id INT NOT NULL,
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produk_kategori
        FOREIGN KEY (kategori_id) REFERENCES kategori(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_pesanan VARCHAR(20) NULL UNIQUE,
    nama_pelanggan VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    metode_pembayaran ENUM('COD', 'Transfer Bank', 'E-Wallet') NOT NULL,
    total_harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    status_pesanan ENUM('Menunggu', 'Diproses', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Menunggu',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pesanan_id INT NOT NULL,
    produk_id INT NULL,
    jumlah INT NOT NULL,
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
    CONSTRAINT fk_detail_pesanan_pesanan
        FOREIGN KEY (pesanan_id) REFERENCES pesanan(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_detail_pesanan_produk
        FOREIGN KEY (produk_id) REFERENCES produk(id)
        ON UPDATE CASCADE
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO users (nama, username, password, role) VALUES
('Administrator', 'admin', '$2y$10$BsGSPVKJoBQBDRFDIZcPjuMwSRU6hmkRGdF.l08KoiHPO5kJOzAC2', 'admin'),
('Staff Gudang', 'staff', '$2y$10$BsGSPVKJoBQBDRFDIZcPjuMwSRU6hmkRGdF.l08KoiHPO5kJOzAC2', 'staff');

INSERT INTO kategori (nama_kategori, deskripsi) VALUES
('Elektronik', 'Produk elektronik dan perangkat pendukung.'),
('Alat Tulis', 'Perlengkapan tulis untuk sekolah dan kantor.'),
('Rumah Tangga', 'Kebutuhan rumah tangga harian.'),
('Makanan Ringan', 'Produk makanan ringan siap jual.');

INSERT INTO produk (nama_produk, kategori_id, harga, stok, deskripsi) VALUES
('Mouse Wireless', 1, 125000, 35, 'Mouse nirkabel ergonomis untuk kerja harian.'),
('Keyboard Mechanical', 1, 450000, 18, 'Keyboard mechanical dengan lampu RGB.'),
('Pulpen Gel Hitam', 2, 5000, 120, 'Pulpen gel warna hitam ukuran 0.5 mm.'),
('Buku Catatan A5', 2, 18000, 64, 'Buku catatan garis ukuran A5.'),
('Sabun Cuci Piring', 3, 15000, 42, 'Sabun cuci piring cair kemasan 750 ml.'),
('Keripik Singkong', 4, 12000, 55, 'Keripik singkong renyah rasa original.');

INSERT INTO pesanan (id, kode_pesanan, nama_pelanggan, no_hp, alamat, metode_pembayaran, total_harga, status_pesanan, created_at) VALUES
(1, 'ORD0001', 'Dewi Larasati', '081234567890', 'Jl. Merdeka No. 10, Denpasar', 'COD', 250000, 'Menunggu', '2026-07-01 09:15:00'),
(2, 'ORD0002', 'Agus Pratama', '082233445566', 'Jl. Melati No. 5, Badung', 'Transfer Bank', 473000, 'Selesai', '2026-07-02 14:30:00');

INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga, subtotal) VALUES
(1, 1, 2, 125000, 250000),
(2, 2, 1, 450000, 450000),
(2, 3, 1, 5000, 5000),
(2, 4, 1, 18000, 18000);
