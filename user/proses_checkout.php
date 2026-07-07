<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'user/checkout.php');
    exit;
}

$cart = get_cart_items($conn);
$nama = trim($_POST['nama_pelanggan'] ?? '');
$noHp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$metode = $_POST['metode_pembayaran'] ?? '';
$metodeList = ['COD', 'Transfer Bank', 'E-Wallet'];

$_SESSION['checkout_old'] = [
    'nama_pelanggan' => $nama,
    'no_hp' => $noHp,
    'alamat' => $alamat,
    'metode_pembayaran' => $metode,
];

if (!$cart['items']) {
    set_flash('danger', 'Keranjang tidak boleh kosong.');
    header('Location: ' . BASE_URL . 'user/keranjang.php');
    exit;
}

if ($nama === '' || $noHp === '' || $alamat === '' || $metode === '') {
    set_flash('danger', 'Semua field checkout wajib diisi.');
    header('Location: ' . BASE_URL . 'user/checkout.php');
    exit;
}

if (!ctype_digit($noHp)) {
    set_flash('danger', 'Nomor HP hanya boleh berisi angka.');
    header('Location: ' . BASE_URL . 'user/checkout.php');
    exit;
}

if (!in_array($metode, $metodeList, true)) {
    set_flash('danger', 'Metode pembayaran tidak valid.');
    header('Location: ' . BASE_URL . 'user/checkout.php');
    exit;
}

mysqli_begin_transaction($conn);

try {
    $status = 'Menunggu';
    $insertPesanan = mysqli_prepare(
        $conn,
        'INSERT INTO pesanan (kode_pesanan, nama_pelanggan, no_hp, alamat, metode_pembayaran, total_harga, status_pesanan)
         VALUES (NULL, ?, ?, ?, ?, ?, ?)'
    );
    mysqli_stmt_bind_param($insertPesanan, 'ssssds', $nama, $noHp, $alamat, $metode, $cart['total'], $status);

    if (!mysqli_stmt_execute($insertPesanan)) {
        throw new Exception('Gagal menyimpan pesanan.');
    }

    $pesananId = mysqli_insert_id($conn);
    $kodePesanan = 'ORD' . str_pad((string) $pesananId, 4, '0', STR_PAD_LEFT);

    $updateKode = mysqli_prepare($conn, 'UPDATE pesanan SET kode_pesanan = ? WHERE id = ?');
    mysqli_stmt_bind_param($updateKode, 'si', $kodePesanan, $pesananId);

    if (!mysqli_stmt_execute($updateKode)) {
        throw new Exception('Gagal membuat kode pesanan.');
    }

    $insertDetail = mysqli_prepare(
        $conn,
        'INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga, subtotal) VALUES (?, ?, ?, ?, ?)'
    );

    foreach ($cart['items'] as $item) {
        $produkId = (int) $item['produk']['id'];
        $jumlah = (int) $item['jumlah'];
        $harga = (float) $item['produk']['harga'];
        $subtotal = (float) $item['subtotal'];

        mysqli_stmt_bind_param($insertDetail, 'iiidd', $pesananId, $produkId, $jumlah, $harga, $subtotal);

        if (!mysqli_stmt_execute($insertDetail)) {
            throw new Exception('Gagal menyimpan detail pesanan.');
        }
    }

    mysqli_commit($conn);
    unset($_SESSION['cart'], $_SESSION['checkout_old']);

    header('Location: ' . BASE_URL . 'user/bukti_pesanan.php?kode=' . urlencode($kodePesanan));
    exit;
} catch (Throwable $error) {
    mysqli_rollback($conn);
    set_flash('danger', 'Checkout gagal diproses. Silakan coba lagi.');
    header('Location: ' . BASE_URL . 'user/checkout.php');
    exit;
}
