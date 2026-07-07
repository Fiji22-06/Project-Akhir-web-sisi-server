<?php
$pageTitle = 'Cek Pesanan';
$activeUserPage = 'cek';
require_once __DIR__ . '/../templates/user_header.php';

$keyword = trim($_GET['keyword'] ?? '');
$pesananResult = null;
$searched = $keyword !== '';

if ($searched) {
    $likeKeyword = '%' . $keyword . '%';
    $pesananResult = prepared_query(
        $conn,
        'SELECT id, kode_pesanan, nama_pelanggan, no_hp, total_harga, status_pesanan, created_at
         FROM pesanan
         WHERE kode_pesanan = ? OR no_hp LIKE ?
         ORDER BY id DESC',
        'ss',
        [$keyword, $likeKeyword]
    );
}
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
        <form method="get" class="check-order-form">
            <label for="keyword" class="form-label">Kode Pesanan atau Nomor HP</label>
            <div class="input-group">
                <input type="text" name="keyword" id="keyword" class="form-control" value="<?= e($keyword); ?>" placeholder="Contoh: ORD0001 atau 08123456789" required>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Cek Pesanan
                </button>
            </div>
        </form>

        <?php if ($searched): ?>
            <?php if ($pesananResult && mysqli_num_rows($pesananResult) > 0): ?>
                <div class="order-result-list">
                    <?php while ($pesanan = mysqli_fetch_assoc($pesananResult)): ?>
                        <div class="order-result-card">
                            <div>
                                <strong><?= e($pesanan['kode_pesanan']); ?></strong>
                                <span><?= e($pesanan['nama_pelanggan']); ?> - <?= date('d M Y H:i', strtotime($pesanan['created_at'])); ?></span>
                            </div>
                            <div>
                                <span class="badge <?= status_badge_class($pesanan['status_pesanan']); ?>"><?= e($pesanan['status_pesanan']); ?></span>
                                <strong><?= rupiah($pesanan['total_harga']); ?></strong>
                            </div>
                            <a href="<?= BASE_URL; ?>user/detail_pesanan.php?kode=<?= urlencode($pesanan['kode_pesanan']); ?>" class="btn btn-outline-primary btn-sm">Detail Pesanan</a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-danger mt-4">Pesanan tidak ditemukan</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
