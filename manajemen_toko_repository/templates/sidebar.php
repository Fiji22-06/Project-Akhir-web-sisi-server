<?php
$currentUser = $_SESSION['user'] ?? ['nama' => 'User', 'role' => ''];
$flash = get_flash();
?>
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <span class="brand-icon"><i class="bi bi-shop"></i></span>
                <span>
                    <strong>Manajemen</strong>
                    <small>Toko</small>
                </span>
            </div>
            <nav class="sidebar-menu">
                <a class="<?= $activePage === 'dashboard' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>pages/dashboard.php">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
                <a class="<?= $activePage === 'pengguna' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>pages/pengguna/index.php">
                    <i class="bi bi-people"></i> Pengguna
                </a>
                <a class="<?= $activePage === 'kategori' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>pages/kategori/index.php">
                    <i class="bi bi-tags"></i> Kategori
                </a>
                <a class="<?= $activePage === 'produk' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>pages/produk/index.php">
                    <i class="bi bi-box"></i> Produk
                </a>
                <a class="<?= $activePage === 'pesanan' ? 'active' : ''; ?>" href="<?= BASE_URL; ?>pages/pesanan/index.php">
                    <i class="bi bi-receipt"></i> Pesanan
                </a>
                <a href="<?= BASE_URL; ?>auth/logout.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="user-mini">
                    <span class="user-avatar"><?= strtoupper(substr($currentUser['nama'], 0, 1)); ?></span>
                    <span>
                        <strong><?= e($currentUser['nama']); ?></strong>
                        <small><?= e(ucfirst($currentUser['role'])); ?></small>
                    </span>
                </div>
            </div>
        </aside>

        <main class="main-content">
            <header class="topbar">
                <button class="btn icon-btn d-lg-none" type="button" id="sidebarToggle" aria-label="Buka menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h2><?= e($pageTitle); ?></h2>
                    <p>Kelola data toko dengan cepat dan rapi.</p>
                </div>
                <a href="<?= BASE_URL; ?>auth/logout.php" class="btn btn-outline-danger ms-auto">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </a>
            </header>

            <div class="content-inner">
                <?php if ($flash): ?>
                    <div class="alert alert-<?= e($flash['type']); ?> alert-dismissible fade show" role="alert">
                        <?= e($flash['message']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                <?php endif; ?>
