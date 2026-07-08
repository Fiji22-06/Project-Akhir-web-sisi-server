<?php
$pageTitle = $data['pageTitle'] ?? 'Akun Saya';
$activeUserPage = $data['activeUserPage'] ?? 'akun';
$customer = $data['customer'];
$orders = $data['orders'] ?? [];
require_once __DIR__ . '/../../../templates/user_header.php';
?>
<section class="page-hero compact">
    <div class="container">
        <span class="section-label">Akun Pelanggan</span>
        <h1>Halo, <?= e($customer['nama']); ?></h1>
        <p>Kelola akses akun pelanggan dan lanjutkan aktivitas belanja Anda.</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="checkout-summary">
                    <h3>Profil Login</h3>
                    <div class="summary-row">
                        <span>Nama</span>
                        <strong><?= e($customer['nama']); ?></strong>
                    </div>
                    <div class="summary-row">
                        <span>Username</span>
                        <strong><?= e($customer['username']); ?></strong>
                    </div>
                    <div class="summary-row">
                        <span>Role</span>
                        <strong>Pelanggan</strong>
                    </div>
                    <a href="<?= BASE_URL; ?>user/logout" class="btn btn-outline-danger w-100 mt-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Logout
                    </a>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="checkout-summary mb-4">
                    <h3>Pesanan Saya</h3>
                    <?php if ($orders): ?>
                        <div class="order-result-list mt-0">
                            <?php foreach ($orders as $order): ?>
                                <div class="order-result-card">
                                    <div>
                                        <strong><?= e($order['kode_pesanan']); ?></strong>
                                        <span><?= date('d M Y H:i', strtotime($order['created_at'])); ?></span>
                                    </div>
                                    <div>
                                        <span class="badge <?= status_badge_class($order['status_pesanan']); ?>"><?= e($order['status_pesanan']); ?></span>
                                        <strong><?= rupiah($order['total_harga']); ?></strong>
                                    </div>
                                    <a href="<?= BASE_URL; ?>pesanan/detail?kode=<?= urlencode($order['kode_pesanan']); ?>" class="btn btn-outline-primary btn-sm">Detail</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-receipt"></i>
                            <h3>Belum ada pesanan</h3>
                            <p>Pesanan yang dibuat saat Anda login akan tampil di sini.</p>
                            <a href="<?= BASE_URL; ?>produk" class="btn btn-primary">Belanja Sekarang</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="<?= BASE_URL; ?>produk" class="order-summary-box d-block h-100 text-dark">
                            <i class="bi bi-bag-check fs-3 text-primary"></i>
                            <h3 class="h5 mt-3">Lihat Produk</h3>
                            <p class="text-muted mb-0">Cari produk dan tambahkan ke keranjang.</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= BASE_URL; ?>keranjang" class="order-summary-box d-block h-100 text-dark">
                            <i class="bi bi-cart3 fs-3 text-success"></i>
                            <h3 class="h5 mt-3">Keranjang</h3>
                            <p class="text-muted mb-0">Lanjutkan checkout dari item pilihan Anda.</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= BASE_URL; ?>pesanan/cek" class="order-summary-box d-block h-100 text-dark">
                            <i class="bi bi-search fs-3 text-warning"></i>
                            <h3 class="h5 mt-3">Cek Pesanan</h3>
                            <p class="text-muted mb-0">Pantau status pesanan dengan kode atau nomor HP.</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="<?= BASE_URL; ?>" class="order-summary-box d-block h-100 text-dark">
                            <i class="bi bi-house-door fs-3 text-info"></i>
                            <h3 class="h5 mt-3">Beranda</h3>
                            <p class="text-muted mb-0">Kembali ke halaman utama TOKO BROD.</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/user_footer.php'; ?>
