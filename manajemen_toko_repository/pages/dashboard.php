<?php
$pageTitle = 'Dashboard';
$activePage = 'dashboard';
require_once __DIR__ . '/../templates/header.php';

$totalPengguna = (int) mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM users'))['total'];
$totalKategori = (int) mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM kategori'))['total'];
$totalProduk = (int) mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM produk'))['total'];
$totalStok = (int) mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COALESCE(SUM(stok), 0) AS total FROM produk'))['total'];
$totalPesanan = (int) mysqli_fetch_assoc(mysqli_query($conn, 'SELECT COUNT(*) AS total FROM pesanan'))['total'];
$totalPendapatan = (float) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_harga), 0) AS total FROM pesanan WHERE status_pesanan = 'Selesai'"))['total'];
$pesananMenunggu = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status_pesanan = 'Menunggu'"))['total'];
$pesananSelesai = (int) mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status_pesanan = 'Selesai'"))['total'];

require_once __DIR__ . '/../templates/sidebar.php';
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
            <h3><?= $totalPengguna; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-success-subtle text-success"><i class="bi bi-tags"></i></span>
        <div>
            <p>Total Kategori</p>
            <h3><?= $totalKategori; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-box"></i></span>
        <div>
            <p>Total Produk</p>
            <h3><?= $totalProduk; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-danger-subtle text-danger"><i class="bi bi-stack"></i></span>
        <div>
            <p>Total Stok Produk</p>
            <h3><?= $totalStok; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-info-subtle text-info"><i class="bi bi-receipt"></i></span>
        <div>
            <p>Total Pesanan</p>
            <h3><?= $totalPesanan; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-success-subtle text-success"><i class="bi bi-cash-stack"></i></span>
        <div>
            <p>Total Pendapatan</p>
            <h3 class="stat-money"><?= rupiah($totalPendapatan); ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-warning-subtle text-warning"><i class="bi bi-hourglass-split"></i></span>
        <div>
            <p>Pesanan Menunggu</p>
            <h3><?= $pesananMenunggu; ?></h3>
        </div>
    </div>
    <div class="stat-card">
        <span class="stat-icon bg-primary-subtle text-primary"><i class="bi bi-check-circle"></i></span>
        <div>
            <p>Pesanan Selesai</p>
            <h3><?= $pesananSelesai; ?></h3>
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
        <a href="<?= BASE_URL; ?>pages/pengguna/index.php" class="quick-link">
            <i class="bi bi-person-plus"></i>
            <span>Kelola Pengguna</span>
        </a>
        <a href="<?= BASE_URL; ?>pages/kategori/index.php" class="quick-link">
            <i class="bi bi-tag"></i>
            <span>Kelola Kategori</span>
        </a>
        <a href="<?= BASE_URL; ?>pages/produk/index.php" class="quick-link">
            <i class="bi bi-plus-square"></i>
            <span>Kelola Produk</span>
        </a>
        <a href="<?= BASE_URL; ?>pages/pesanan/index.php" class="quick-link">
            <i class="bi bi-receipt-cutoff"></i>
            <span>Kelola Pesanan</span>
        </a>
    </div>
</section>
<?php require_once __DIR__ . '/../templates/footer.php'; ?>
