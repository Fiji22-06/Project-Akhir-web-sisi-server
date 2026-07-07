<?php
require_once __DIR__ . '/../config/database.php';

$produkId = (int) ($_POST['produk_id'] ?? 0);
$jumlah = (int) ($_POST['jumlah'] ?? 0);

if ($produkId <= 0 || !isset($_SESSION['cart'][$produkId])) {
    set_flash('danger', 'Item keranjang tidak ditemukan.');
    header('Location: ' . BASE_URL . 'user/keranjang.php');
    exit;
}

if ($jumlah <= 0) {
    unset($_SESSION['cart'][$produkId]);
    set_flash('success', 'Produk dihapus dari keranjang.');
    header('Location: ' . BASE_URL . 'user/keranjang.php');
    exit;
}

$produk = mysqli_fetch_assoc(prepared_query($conn, 'SELECT stok FROM produk WHERE id = ?', 'i', [$produkId]));

if (!$produk || (int) $produk['stok'] <= 0) {
    unset($_SESSION['cart'][$produkId]);
    set_flash('danger', 'Produk tidak tersedia dan dihapus dari keranjang.');
    header('Location: ' . BASE_URL . 'user/keranjang.php');
    exit;
}

$_SESSION['cart'][$produkId] = min($jumlah, (int) $produk['stok']);
set_flash('success', 'Jumlah produk berhasil diperbarui.');
header('Location: ' . BASE_URL . 'user/keranjang.php');
exit;
