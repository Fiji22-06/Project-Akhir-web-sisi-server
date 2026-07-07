<?php
require_once __DIR__ . '/../../config/database.php';
require_login();

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    set_flash('danger', 'Data pengguna tidak valid.');
    header('Location: ' . BASE_URL . 'pages/pengguna/index.php');
    exit;
}

if ((int) $_SESSION['user']['id'] === $id) {
    set_flash('danger', 'Akun yang sedang digunakan tidak dapat dihapus.');
    header('Location: ' . BASE_URL . 'pages/pengguna/index.php');
    exit;
}

$stmt = mysqli_prepare($conn, 'DELETE FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (mysqli_stmt_execute($stmt)) {
    set_flash('success', 'Pengguna berhasil dihapus.');
} else {
    set_flash('danger', 'Pengguna gagal dihapus.');
}

header('Location: ' . BASE_URL . 'pages/pengguna/index.php');
exit;
