<?php
$pageTitle = 'Detail Pesanan';
$activeUserPage = 'cek';
require_once __DIR__ . '/../templates/user_header.php';

$kode = trim($_GET['kode'] ?? '');
$pesanan = mysqli_fetch_assoc(prepared_query($conn, 'SELECT * FROM pesanan WHERE kode_pesanan = ?', 's', [$kode]));

if (!$pesanan) {
    set_flash('danger', 'Pesanan tidak ditemukan.');
    header('Location: ' . BASE_URL . 'user/cek_pesanan.php');
    exit;
}

$detail = prepared_query(
    $conn,
    'SELECT detail_pesanan.*, produk.nama_produk
     FROM detail_pesanan
     LEFT JOIN produk ON produk.id = detail_pesanan.produk_id
     WHERE detail_pesanan.pesanan_id = ?
     ORDER BY detail_pesanan.id ASC',
    'i',
    [(int) $pesanan['id']]
);
?>
<section class="shop-section">
    <div class="container">
        <div class="data-panel public-detail-panel">
            <div class="panel-header">
                <div>
                    <span class="section-label">Detail Pesanan</span>
                    <h3><?= e($pesanan['kode_pesanan']); ?></h3>
                </div>
                <span class="badge <?= status_badge_class($pesanan['status_pesanan']); ?>"><?= e($pesanan['status_pesanan']); ?></span>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="order-summary-box">
                        <div class="summary-row"><span>Nama</span><strong><?= e($pesanan['nama_pelanggan']); ?></strong></div>
                        <div class="summary-row"><span>Nomor HP</span><strong><?= e($pesanan['no_hp']); ?></strong></div>
                        <div class="summary-row"><span>Alamat</span><strong><?= e($pesanan['alamat']); ?></strong></div>
                        <div class="summary-row"><span>Pembayaran</span><strong><?= e($pesanan['metode_pembayaran']); ?></strong></div>
                        <div class="summary-row"><span>Tanggal</span><strong><?= date('d M Y H:i', strtotime($pesanan['created_at'])); ?></strong></div>
                    </div>
                </div>
                <div class="col-lg-7">
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
                                <?php while ($row = mysqli_fetch_assoc($detail)): ?>
                                    <tr>
                                        <td><?= e($row['nama_produk'] ?? 'Produk dihapus'); ?></td>
                                        <td><?= rupiah($row['harga']); ?></td>
                                        <td><?= (int) $row['jumlah']; ?></td>
                                        <td><?= rupiah($row['subtotal']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total Harga</th>
                                    <th><?= rupiah($pesanan['total_harga']); ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <a href="<?= BASE_URL; ?>user/cek_pesanan.php" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
