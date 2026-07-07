<?php
require_once __DIR__ . '/../config/database.php';

$pageTitle = $pageTitle ?? 'Toko Online';
$activeUserPage = $activeUserPage ?? '';
$flash = get_flash();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle); ?> | Toko Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body class="user-site">
    <nav class="navbar navbar-expand-lg user-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE_URL; ?>user/">
                <span class="user-brand-icon"><i class="bi bi-shop"></i></span>
                Toko Online
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#userNavbar" aria-controls="userNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="userNavbar">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                    <li class="nav-item">
                        <a class="nav-link <?= $activeUserPage === 'home' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>user/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activeUserPage === 'produk' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>user/produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $activeUserPage === 'cek' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>user/cek_pesanan.php">Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cart-link <?= $activeUserPage === 'keranjang' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>user/keranjang.php">
                            <i class="bi bi-cart3"></i>
                            Keranjang
                            <span class="badge text-bg-success"><?= get_cart_count(); ?></span>
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-primary btn-sm" href="<?= BASE_URL; ?>auth/login.php">
                            <i class="bi bi-shield-lock me-1"></i> Login Admin
                        </a>
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
