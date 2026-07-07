<?php
$pageTitle = 'Checkout';
$activeUserPage = 'keranjang';
require_once __DIR__ . '/../templates/user_header.php';

$cart = get_cart_items($conn);

if (!$cart['items']) {
    set_flash('danger', 'Keranjang masih kosong.');
    header('Location: ' . BASE_URL . 'user/keranjang.php');
    exit;
}
?>
<section class="page-hero compact">
    <div class="container">
        <span class="section-label">Checkout</span>
        <h1>Data Pesanan</h1>
        <p>Isi data diri dengan benar agar pesanan mudah diproses.</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <div class="checkout-layout">
            <form action="<?= BASE_URL; ?>user/proses_checkout.php" method="post" class="checkout-form">
                <h3>Data Pelanggan</h3>
                <div class="mb-3">
                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" value="<?= e($_SESSION['checkout_old']['nama_pelanggan'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" name="no_hp" id="no_hp" class="form-control" value="<?= e($_SESSION['checkout_old']['no_hp'] ?? ''); ?>" pattern="[0-9]+" inputmode="numeric" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" class="form-control" rows="4" required><?= e($_SESSION['checkout_old']['alamat'] ?? ''); ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                    <?php $selectedMetode = $_SESSION['checkout_old']['metode_pembayaran'] ?? ''; ?>
                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                        <option value="">Pilih metode pembayaran</option>
                        <?php foreach (['COD', 'Transfer Bank', 'E-Wallet'] as $metode): ?>
                            <option value="<?= e($metode); ?>" <?= $selectedMetode === $metode ? 'selected' : ''; ?>>
                                <?= e($metode); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php unset($_SESSION['checkout_old']); ?>
                <div class="form-actions">
                    <a href="<?= BASE_URL; ?>user/keranjang.php" class="btn btn-light">Kembali</a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check2-circle me-1"></i> Buat Pesanan
                    </button>
                </div>
            </form>

            <aside class="checkout-summary">
                <h3>Ringkasan Pesanan</h3>
                <?php foreach ($cart['items'] as $item): ?>
                    <div class="checkout-item">
                        <div>
                            <strong><?= e($item['produk']['nama_produk']); ?></strong>
                            <span><?= (int) $item['jumlah']; ?> x <?= rupiah($item['produk']['harga']); ?></span>
                        </div>
                        <strong><?= rupiah($item['subtotal']); ?></strong>
                    </div>
                <?php endforeach; ?>
                <div class="summary-row total">
                    <span>Total Harga</span>
                    <strong><?= rupiah($cart['total']); ?></strong>
                </div>
            </aside>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
