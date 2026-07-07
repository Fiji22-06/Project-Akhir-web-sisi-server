<?php
$pageTitle = $data['pageTitle'] ?? 'Produk';
$activeUserPage = $data['activeUserPage'] ?? 'produk';
require_once __DIR__ . '/../../../templates/user_header.php';
?>
<section class="page-hero compact">
    <div class="container">
        <span class="section-label">Katalog</span>
        <h1>Daftar Produk</h1>
        <p>Cari produk berdasarkan nama atau pilih kategori yang tersedia.</p>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <form method="get" action="<?= BASE_URL; ?>produk" class="filter-bar">
            <div>
                <label for="q" class="form-label">Cari Produk</label>
                <input type="text" name="q" id="q" class="form-control" value="<?= e($data['keyword']); ?>" placeholder="Contoh: mouse">
            </div>
            <div>
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select">
                    <option value="0">Semua kategori</option>
                    <?php foreach ($data['kategori'] as $kategori): ?>
                        <option value="<?= $kategori['id']; ?>" <?= $data['kategoriId'] === (int) $kategori['id'] ? 'selected' : ''; ?>>
                            <?= e($kategori['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                <a href="<?= BASE_URL; ?>produk" class="btn btn-light">Reset</a>
            </div>
        </form>

        <div class="product-grid mt-4">
            <?php if (count($data['produk']) > 0): ?>
                <?php foreach ($data['produk'] as $produk): ?>
                    <article class="product-card">
                        <div class="product-visual">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <div class="product-body">
                            <span class="badge text-bg-light"><?= e($produk['nama_kategori'] ?? 'Tanpa Kategori'); ?></span>
                            <h3><?= e($produk['nama_produk']); ?></h3>
                            <p><?= e(short_text($produk['deskripsi'], 85)); ?></p>
                            <div class="product-meta">
                                <strong><?= rupiah($produk['harga']); ?></strong>
                                <span>Stok <?= (int) $produk['stok']; ?></span>
                            </div>
                            <div class="product-actions">
                                <a href="<?= BASE_URL; ?>produk/detail?id=<?= $produk['id']; ?>" class="btn btn-outline-primary btn-sm">Detail</a>
                                <form action="<?= BASE_URL; ?>keranjang/tambah" method="post">
                                    <input type="hidden" name="produk_id" value="<?= $produk['id']; ?>">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn btn-success btn-sm" <?= (int) $produk['stok'] <= 0 ? 'disabled' : ''; ?>>
                                        <i class="bi bi-cart-plus me-1"></i> Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-search"></i>
                    <h3>Produk tidak ditemukan</h3>
                    <p>Coba gunakan kata kunci atau kategori lain.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/user_footer.php'; ?>
