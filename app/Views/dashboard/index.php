<?php
$pageTitle = $data['pageTitle'] ?? 'Dashboard';
$activePage = $data['activePage'] ?? 'dashboard';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';

$stats = $data['stats'];
?>
<section class="welcome-section">
    <div>
        <span class="section-label">Selamat datang</span>
        <h1>Halo, <?= e($_SESSION['user']['nama']); ?>!</h1>
        <p>Gunakan dashboard ini untuk memantau ringkasan data dan mengelola produk toko.</p>
    </div>
    <div class="welcome-badge">
        <i class="bi bi-graph-up-arrow"></i>
    </div>
</section>

<section class="stats-grid">
    <div class="stat-card">
        <span class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-people"></i></span>
        <div>
            <p>Total Pengguna</p>
            <h3><?= $stats['totalPengguna']; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-success-subtle text-success"><i class="bi bi-tags"></i></span>
        <div>
            <p>Total Kategori</p>
            <h3><?= $stats['totalKategori']; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-box"></i></span>
        <div>
            <p>Total Produk</p>
            <h3><?= $stats['totalProduk']; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-stack"></i></span>
        <div>
            <p>Total Stok Produk</p>
            <h3><?= $stats['totalStok']; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-info-subtle text-info"><i class="bi bi-receipt"></i></span>
        <div>
            <p>Total Pesanan</p>
            <h3><?= $stats['totalPesanan']; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-success-subtle text-success"><i class="bi bi-cash-stack"></i></span>
        <div>
            <p>Total Pendapatan</p>
            <h3 class="stat-money"><?= rupiah($stats['totalPendapatan']); ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-hourglass-split"></i></span>
        <div>
            <p>Pesanan Menunggu</p>
            <h3><?= $stats['pesananMenunggu']; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-check-circle"></i></span>
        <div>
            <p>Pesanan Selesai</p>
            <h3><?= $stats['pesananSelesai']; ?></h3>
        </div>
    </div>
</section>

<section class="data-panel mt-4">
    <div class="panel-header">
        <div>
            <h3>Menu Cepat</h3>
            <p>Pilih data yang ingin dikelola.</p>
        </div>
    </div>
    <div class="quick-actions">
        <a href="<?= BASE_URL; ?>pengguna" class="quick-link">
            <i class="bi bi-person-plus"></i>
            <span>Kelola Pengguna</span>
        </a>
        <a href="<?= BASE_URL; ?>kategori" class="quick-link">
            <i class="bi bi-tag"></i>
            <span>Kelola Kategori</span>
        </a>
        <a href="<?= BASE_URL; ?>adminproduk" class="quick-link">
            <i class="bi bi-plus-square"></i>
            <span>Kelola Produk</span>
        </a>
        <a href="<?= BASE_URL; ?>adminpesanan" class="quick-link">
            <i class="bi bi-receipt-cutoff"></i>
            <span>Kelola Pesanan</span>
        </a>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
