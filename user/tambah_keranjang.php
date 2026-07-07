<?php
require_once __DIR__ . '/../config/database.php';

$produkId = (int) ($_POST['produk_id'] ?? 0);
$jumlah = max(1, (int) ($_POST['jumlah'] ?? 1));

$produk = mysqli_fetch_assoc(prepared_query($conn, 'SELECT id, stok FROM produk WHERE id = ?', 'i', [$produkId]));

if (!$produk) {
    set_flash('danger', 'Produk tidak ditemukan.');
    header('Location: ' . BASE_URL . 'user/produk.php');
    exit;
}

if ((int) $produk['stok'] <= 0) {
    set_flash('danger', 'Stok produk sedang kosong.');
    header('Location: ' . BASE_URL . 'user/detail_produk.php?id=' . $produkId);
    exit;
}

$_SESSION['cart'] = $_SESSION['cart'] ?? [];
$jumlahBaru = (int) ($_SESSION['cart'][$produkId] ?? 0) + $jumlah;
$_SESSION['cart'][$produkId] = min($jumlahBaru, (int) $produk['stok']);

set_flash('success', 'Produk berhasil ditambahkan ke keranjang.');
header('Location: ' . BASE_URL . 'user/keranjang.php');
exit;
