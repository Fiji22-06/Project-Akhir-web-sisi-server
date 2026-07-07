<?php
$pageTitle = 'Detail Produk';
$activeUserPage = 'produk';
require_once __DIR__ . '/../templates/user_header.php';

$id = (int) ($_GET['id'] ?? 0);
$produk = mysqli_fetch_assoc(prepared_query(
    $conn,
    'SELECT produk.*, kategori.nama_kategori
     FROM produk
     LEFT JOIN kategori ON kategori.id = produk.kategori_id
     WHERE produk.id = ?',
    'i',
    [$id]
));

if (!$produk) {
    set_flash('danger', 'Produk tidak ditemukan.');
    header('Location: ' . BASE_URL . 'user/produk.php');
    exit;
}
?>
<section class="shop-section">
    <div class="container">
        <div class="product-detail">
            <div class="product-detail-visual">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="product-detail-body">
                <span class="badge text-bg-light"><?= e($produk['nama_kategori'] ?? 'Tanpa Kategori'); ?></span>
                <h1><?= e($produk['nama_produk']); ?></h1>
                <div class="detail-price"><?= rupiah($produk['harga']); ?></div>
                <p><?= nl2br(e($produk['deskripsi'])); ?></p>
                <div class="stock-box">
                    <i class="bi bi-stack"></i>
                    <span>Stok tersedia: <strong><?= (int) $produk['stok']; ?></strong></span>
                </div>

                <form action="<?= BASE_URL; ?>user/tambah_keranjang.php" method="post" class="detail-cart-form">
                    <input type="hidden" name="produk_id" value="<?= $produk['id']; ?>">
                    <div>
                        <label for="jumlah" class="form-label">Jumlah Pembelian</label>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" max="<?= max(1, (int) $produk['stok']); ?>" value="1" required>
                    </div>
                    <button type="submit" class="btn btn-success" <?= (int) $produk['stok'] <= 0 ? 'disabled' : ''; ?>>
                        <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
                    </button>
                    <a href="<?= BASE_URL; ?>user/produk.php" class="btn btn-light">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
