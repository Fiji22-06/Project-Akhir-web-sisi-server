<?php
require_once __DIR__ . '/../../config/database.php';
require_login();

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    set_flash('danger', 'Data kategori tidak valid.');
    header('Location: ' . BASE_URL . 'pages/kategori/index.php');
    exit;
}

$stmt = mysqli_prepare($conn, 'DELETE FROM kategori WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    set_flash('success', 'Kategori berhasil dihapus.');
} else {
    set_flash('danger', 'Kategori gagal dihapus karena masih digunakan oleh produk.');
}

header('Location: ' . BASE_URL . 'pages/kategori/index.php');
exit;
