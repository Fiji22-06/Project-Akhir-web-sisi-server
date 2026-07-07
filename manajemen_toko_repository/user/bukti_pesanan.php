<?php
$pageTitle = 'Bukti Pesanan';
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
    <div class="container receipt-wrap">
        <div class="receipt-card">
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

            <div class="receipt-actions">
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <a href="<?= BASE_URL; ?>user/" class="btn btn-light">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
