<?php
$pageTitle = $data['pageTitle'] ?? 'Detail Pesanan';
$activePage = $data['activePage'] ?? 'pesanan';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$pesanan = $data['pesanan'];
$detail = $data['detail'];
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Detail <?= e($pesanan['kode_pesanan']); ?></h3>
            <p>Informasi lengkap pesanan pelanggan.</p>
        </div>
        <a href="<?= BASE_URL; ?>adminpesanan" class="btn btn-light">Kembali</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="order-summary-box">
                <div class="summary-row"><span>Nama</span><strong><?= e($pesanan['nama_pelanggan']); ?></strong></div>
                <div class="summary-row"><span>Nomor HP</span><strong><?= e($pesanan['no_hp']); ?></strong></div>
                <div class="summary-row"><span>Alamat</span><strong><?= e($pesanan['alamat']); ?></strong></div>
                <div class="summary-row"><span>Pembayaran</span><strong><?= e($pesanan['metode_pembayaran']); ?></strong></div>
                <div class="summary-row"><span>Status</span><span class="badge <?= status_badge_class($pesanan['status_pesanan']); ?>"><?= e($pesanan['status_pesanan']); ?></span></div>
                <div class="summary-row"><span>Tanggal</span><strong><?= date('d M Y H:i', strtotime($pesanan['created_at'])); ?></strong></div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
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
                            <th colspan="3" class="text-end">Total</th>
                            <th><?= rupiah($pesanan['total_harga']); ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
