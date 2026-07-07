<?php
$pageTitle = 'Produk';
$activeUserPage = 'produk';
require_once __DIR__ . '/../templates/user_header.php';

$keyword = trim($_GET['q'] ?? '');
$kategoriId = (int) ($_GET['kategori_id'] ?? 0);
$kategoriResult = mysqli_query($conn, 'SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC');

$sql = 'SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, produk.deskripsi, kategori.nama_kategori
        FROM produk
        LEFT JOIN kategori ON kategori.id = produk.kategori_id
        WHERE 1 = 1';
$types = '';
$params = [];

if ($keyword !== '') {
    $sql .= ' AND produk.nama_produk LIKE ?';
    $types .= 's';
    $params[] = '%' . $keyword . '%';
}

if ($kategoriId > 0) {
    $sql .= ' AND produk.kategori_id = ?';
    $types .= 'i';
    $params[] = $kategoriId;
}

$sql .= ' ORDER BY produk.id DESC';
$produkResult = prepared_query($conn, $sql, $types, $params);
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
        <form method="get" class="filter-bar">
            <div>
                <label for="q" class="form-label">Cari Produk</label>
                <input type="text" name="q" id="q" class="form-control" value="<?= e($keyword); ?>" placeholder="Contoh: mouse">
            </div>
            <div>
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select">
                    <option value="0">Semua kategori</option>
                    <?php while ($kategori = mysqli_fetch_assoc($kategoriResult)): ?>
                        <option value="<?= $kategori['id']; ?>" <?= $kategoriId === (int) $kategori['id'] ? 'selected' : ''; ?>>
                            <?= e($kategori['nama_kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i> Cari
                </button>
                <a href="<?= BASE_URL; ?>user/produk.php" class="btn btn-light">Reset</a>
            </div>
        </form>

        <div class="product-grid mt-4">
            <?php if (mysqli_num_rows($produkResult) > 0): ?>
                <?php while ($produk = mysqli_fetch_assoc($produkResult)): ?>
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
                                <a href="<?= BASE_URL; ?>user/detail_produk.php?id=<?= $produk['id']; ?>" class="btn btn-outline-primary btn-sm">Detail</a>
                                <form action="<?= BASE_URL; ?>user/tambah_keranjang.php" method="post">
                                    <input type="hidden" name="produk_id" value="<?= $produk['id']; ?>">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="btn btn-success btn-sm" <?= (int) $produk['stok'] <= 0 ? 'disabled' : ''; ?>>
                                        <i class="bi bi-cart-plus me-1"></i> Keranjang
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
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
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
