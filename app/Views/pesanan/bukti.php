<?php
$pageTitle = $data['pageTitle'] ?? 'Bukti Pesanan';
$activeUserPage = $data['activeUserPage'] ?? 'cek';
require_once __DIR__ . '/../../../templates/user_header.php';

$pesanan = $data['pesanan'];
$detail = $data['detail'];
?>
<section class="shop-section">
    <div class="container receipt-wrap">
        <div class="receipt-card">
            <div class="alert alert-success d-flex gap-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4"></i>
                <div>
                    <strong>Pesanan berhasil diterima.</strong>
                    <div>Kode pesanan Anda adalah <strong><?= e($pesanan['kode_pesanan']); ?></strong>. Status awal pesanan adalah <strong><?= e($pesanan['status_pesanan']); ?></strong>.</div>
                </div>
            </div>

            <div class="receipt-header">
                <div>
                    <span class="section-label">Bukti Pesanan</span>
                    <h1><?= e($pesanan['kode_pesanan']); ?></h1>
                </div>
                <span class="badge <?= status_badge_class($pesanan['status_pesanan']); ?>"><?= e($pesanan['status_pesanan']); ?></span>
            </div>

            <div class="receipt-info">
                <div><span>Nama</span><strong><?= e($pesanan['nama_pelanggan']); ?></strong></div>
                <div><span>Nomor HP</span><strong><?= e($pesanan['no_hp']); ?></strong></div>
                <div><span>Metode</span><strong><?= e($pesanan['metode_pembayaran']); ?></strong></div>
                <div><span>Tanggal</span><strong><?= date('d M Y H:i', strtotime($pesanan['created_at'])); ?></strong></div>
                <div class="full"><span>Alamat</span><strong><?= e($pesanan['alamat']); ?></strong></div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($detail as $row): ?>
                            <tr>
                                <td><?= e($row['nama_produk'] ?? 'Produk dihapus'); ?></td>
                                <td><?= rupiah($row['harga']); ?></td>
                                <td><?= (int) $row['jumlah']; ?></td>
                                <td><?= rupiah($row['subtotal']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total Harga</th>
                            <th><?= rupiah($pesanan['total_harga']); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="receipt-actions">
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <a href="<?= BASE_URL; ?>pesanan/cek?keyword=<?= urlencode($pesanan['kode_pesanan']); ?>" class="btn btn-outline-primary">Cek Status Pesanan</a>
                <?php if (customer_logged_in()): ?>
                    <a href="<?= BASE_URL; ?>user/akun" class="btn btn-outline-success">Akun Saya</a>
                <?php endif; ?>
                <a href="<?= BASE_URL; ?>" class="btn btn-light">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/user_footer.php'; ?>
