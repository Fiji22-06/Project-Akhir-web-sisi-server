<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_manajemen_toko';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8mb4');

define('BASE_URL', '/manajemen_toko/');

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka)
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

function short_text($text, $length = 90)
{
    $text = trim((string) $text);

    if (strlen($text) <= $length) {
        return $text;
    }

    return substr($text, 0, $length) . '...';
}

function prepared_query($conn, $sql, $types = '', array $params = [])
{
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die('Query gagal disiapkan: ' . mysqli_error($conn));
    }

    if ($types !== '' && $params) {
        $bind = [$stmt, $types];

        foreach ($params as $key => $value) {
            $bind[] = &$params[$key];
        }

        call_user_func_array('mysqli_stmt_bind_param', $bind);
    }

    mysqli_stmt_execute($stmt);

    return mysqli_stmt_get_result($stmt);
}

function set_flash($type, $message)
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function get_flash()
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $flash;
}

function require_login()
{
    if (empty($_SESSION['logged_in'])) {
        header('Location: ' . BASE_URL . 'auth/login.php');
        exit;
    }
}

function status_badge_class($status)
{
    $classes = [
        'Menunggu' => 'text-bg-warning',
        'Diproses' => 'text-bg-primary',
        'Selesai' => 'text-bg-success',
        'Dibatalkan' => 'text-bg-danger',
    ];

    return $classes[$status] ?? 'text-bg-secondary';
}

function get_cart_count()
{
    $total = 0;

    foreach ($_SESSION['cart'] ?? [] as $jumlah) {
        $total += (int) $jumlah;
    }

    return $total;
}

function get_cart_items($conn)
{
    $cart = $_SESSION['cart'] ?? [];
    $items = [];
    $total = 0;

    foreach ($cart as $produkId => $jumlah) {
        $produkId = (int) $produkId;
        $jumlah = max(1, (int) $jumlah);

        $result = prepared_query(
            $conn,
            'SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, produk.deskripsi, kategori.nama_kategori
             FROM produk
             LEFT JOIN kategori ON kategori.id = produk.kategori_id
             WHERE produk.id = ?',
            'i',
            [$produkId]
        );
        $produk = mysqli_fetch_assoc($result);

        if (!$produk) {
            unset($_SESSION['cart'][$produkId]);
            continue;
        }

        $stok = (int) $produk['stok'];

        if ($stok <= 0) {
            unset($_SESSION['cart'][$produkId]);
            continue;
        }

        $jumlah = min($jumlah, $stok);
        $_SESSION['cart'][$produkId] = $jumlah;
        $subtotal = (float) $produk['harga'] * $jumlah;
        $total += $subtotal;

        $items[] = [
            'produk' => $produk,
            'jumlah' => $jumlah,
            'subtotal' => $subtotal,
        ];
    }

    return [
        'items' => $items,
        'total' => $total,
    ];
}
