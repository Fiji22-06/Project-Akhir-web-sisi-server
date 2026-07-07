<?php
require_once __DIR__ . '/../../config/database.php';
require_login();

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    set_flash('danger', 'Data produk tidak valid.');
    header('Location: ' . BASE_URL . 'pages/produk/index.php');
    exit;
}

$stmt = mysqli_prepare($conn, 'DELETE FROM produk WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    set_flash('success', 'Produk berhasil dihapus.');
} else {
    set_flash('danger', 'Produk gagal dihapus.');
}

header('Location: ' . BASE_URL . 'pages/produk/index.php');
exit;
