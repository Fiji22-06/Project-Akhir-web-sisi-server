<?php
$pageTitle = $data['pageTitle'] ?? 'Keranjang';
$activeUserPage = $data['activeUserPage'] ?? 'keranjang';
require_once __DIR__ . '/../../../templates/user_header.php';
$cart = $data['cart'];
?>
<section class="page-hero compact">
    <div class="container">
        <span class="section-label">Belanja</span>
        <h1>Keranjang</h1>
        <p>Periksa produk dan jumlah pembelian sebelum checkout.</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <?php if (!$cart['items']): ?>
            <div class="empty-state">
                <i class="bi bi-cart-x"></i>
                <h3>Keranjang masih kosong</h3>
                <p>Tambahkan produk dari halaman katalog untuk mulai checkout.</p>
                <a href="<?= BASE_URL; ?>produk" class="btn btn-primary">Lihat Produk</a>
            </div>
        <?php else: ?>
            <div class="cart-layout">
                <div class="cart-table">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart['items'] as $item): ?>
                                    <?php $produk = $item['produk']; ?>
                                    <tr>
                                        <td>
                                            <strong><?= e($produk['nama_produk']); ?></strong>
                                            <small class="d-block text-muted"><?= e($produk['nama_kategori'] ?? 'Tanpa Kategori'); ?></small>
                                        </td>
                                        <td><?= rupiah($produk['harga']); ?></td>
                                        <td>
                                            <form action="<?= BASE_URL; ?>keranjang/update" method="post" class="qty-form">
                                                <input type="hidden" name="produk_id" value="<?= $produk['id']; ?>">
                                                <input type="number" name="jumlah" class="form-control form-control-sm" min="1" max="<?= (int) $produk['stok']; ?>" value="<?= (int) $item['jumlah']; ?>">
                                                <button type="submit" class="btn btn-warning btn-sm">Update</button>
                                            </form>
                                        </td>
                                        <td><?= rupiah($item['subtotal']); ?></td>
                                        <td class="text-end">
                                            <a href="<?= BASE_URL; ?>keranjang/hapus?id=<?= $produk['id']; ?>" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Hapus produk dari keranjang?');">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <aside class="checkout-summary">
                    <h3>Ringkasan</h3>
                    <div class="summary-row">
                        <span>Total Belanja</span>
                        <strong><?= rupiah($cart['total']); ?></strong>
                    </div>
                    <a href="<?= BASE_URL; ?>checkout" class="btn btn-success w-100">
                        <i class="bi bi-bag-check me-1"></i> Lanjut Checkout
                    </a>
                    <a href="<?= BASE_URL; ?>produk" class="btn btn-light w-100 mt-2">Tambah Produk</a>
                </aside>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/user_footer.php'; ?>
