<?php
require_once __DIR__ . '/../../config/database.php';
require_login();

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    set_flash('danger', 'Data pesanan tidak valid.');
    header('Location: ' . BASE_URL . 'pages/pesanan/index.php');
    exit;
}

mysqli_begin_transaction($conn);

try {
    $deleteDetail = mysqli_prepare($conn, 'DELETE FROM detail_pesanan WHERE pesanan_id = ?');
    mysqli_stmt_bind_param($deleteDetail, 'i', $id);
    mysqli_stmt_execute($deleteDetail);

    $deletePesanan = mysqli_prepare($conn, 'DELETE FROM pesanan WHERE id = ?');
    mysqli_stmt_bind_param($deletePesanan, 'i', $id);
    mysqli_stmt_execute($deletePesanan);

    mysqli_commit($conn);
    set_flash('success', 'Pesanan berhasil dihapus.');
} catch (Throwable $error) {
    mysqli_rollback($conn);
    set_flash('danger', 'Pesanan gagal dihapus.');
}

header('Location: ' . BASE_URL . 'pages/pesanan/index.php');
exit;
