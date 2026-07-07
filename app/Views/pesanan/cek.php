<?php
$pageTitle = $data['pageTitle'] ?? 'Cek Pesanan';
$activeUserPage = $data['activeUserPage'] ?? 'cek';
require_once __DIR__ . '/../../../templates/user_header.php';

$keyword = $data['keyword'];
$searched = $data['searched'];
$pesananResult = $data['pesananResult'];
?>
<section class="page-hero compact">
    <div class="container">
        <span class="section-label">Status Pesanan</span>
        <h1>Cek Pesanan</h1>
        <p>Masukkan kode pesanan atau nomor HP untuk melihat status pesanan.</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <form method="get" action="<?= BASE_URL; ?>pesanan/cek" class="check-order-form">
            <label for="keyword" class="form-label">Kode Pesanan atau Nomor HP</label>
            <div class="input-group">
                <input type="text" name="keyword" id="keyword" class="form-control" value="<?= e($keyword); ?>" placeholder="Contoh: ORD0001 atau 08123456789" required>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Cek Pesanan
                </button>
            </div>
        </form>

        <?php if ($searched): ?>
            <?php if ($pesananResult && count($pesananResult) > 0): ?>
                <div class="order-result-list">
                    <?php foreach ($pesananResult as $pesanan): ?>
                        <div class="order-result-card">
                            <div>
                                <strong><?= e($pesanan['kode_pesanan']); ?></strong>
                                <span><?= e($pesanan['nama_pelanggan']); ?> - <?= date('d M Y H:i', strtotime($pesanan['created_at'])); ?></span>
                            </div>
                            <div>
                                <span class="badge <?= status_badge_class($pesanan['status_pesanan']); ?>"><?= e($pesanan['status_pesanan']); ?></span>
                                <strong><?= rupiah($pesanan['total_harga']); ?></strong>
                            </div>
                            <a href="<?= BASE_URL; ?>pesanan/detail?kode=<?= urlencode($pesanan['kode_pesanan']); ?>" class="btn btn-outline-primary btn-sm">Detail Pesanan</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-danger mt-4">Pesanan tidak ditemukan</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/user_footer.php'; ?>
