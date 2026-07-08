<?php
require_once __DIR__ . '/../config/database.php';

$pageTitle = $pageTitle ?? 'TOKO BROD';
$activeUserPage = $activeUserPage ?? '';
$flash = get_flash();
$customer = get_customer();
$customerFirstName = '';

if ($customer) {
    $nameParts = preg_split('/\s+/', trim($customer['nama']));
    $customerFirstName = $nameParts[0] ?? $customer['nama'];
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle); ?> | TOKO BROD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body class="user-site">
    <nav class="navbar navbar-expand-lg user-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL; ?>">
                <span class="user-brand-icon"><i class="bi bi-shop"></i></span>
                TOKO BROD
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="userNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link <?= $activeUserPage === 'home' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activeUserPage === 'produk' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activeUserPage === 'cek' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>pesanan/cek">Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link <?= $activeUserPage === 'keranjang' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>keranjang">
                            <i class="bi bi-cart3"></i>
                            Keranjang
                            <span class="badge text-bg-success cart-count-badge"><?= get_cart_count(); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <?php if (customer_logged_in()): ?>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> <?= e($customerFirstName); ?>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>user/akun"><i class="bi bi-person me-2"></i>Akun Saya</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>pesanan/cek"><i class="bi bi-receipt me-2"></i>Cek Pesanan</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>auth/login"><i class="bi bi-shield-lock me-2"></i>Login Admin</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="<?= BASE_URL; ?>user/logout"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        <?php else: ?>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle me-1"></i> Login
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>user/login"><i class="bi bi-person me-2"></i>Login User</a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL; ?>auth/login"><i class="bi bi-shield-lock me-2"></i>Login Admin</a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?php if ($flash): ?>
            <div class="container mt-4">
                <div class="alert alert-<?= e($flash['type']); ?> alert-dismissible fade show" role="alert">
                    <?= e($flash['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
            </div>
        <?php endif; ?>
