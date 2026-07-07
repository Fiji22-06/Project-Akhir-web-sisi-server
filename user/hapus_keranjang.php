<?php
require_once __DIR__ . '/../config/database.php';

$produkId = (int) ($_GET['id'] ?? 0);

if ($produkId > 0 && isset($_SESSION['cart'][$produkId])) {
    unset($_SESSION['cart'][$produkId]);
    set_flash('success', 'Produk berhasil dihapus dari keranjang.');
} else {
    set_flash('danger', 'Produk tidak ditemukan di keranjang.');
}

header('Location: ' . BASE_URL . 'user/keranjang.php');
exit;
