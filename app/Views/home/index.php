<?php
$pageTitle = $data['pageTitle'] ?? 'Beranda';
$activeUserPage = $data['activeUserPage'] ?? 'home';
// Since index.php acts as the front controller, __DIR__ works from the views folder
require_once __DIR__ . '/../../../templates/user_header.php';
?>

<section class="shop-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 hero-text-animate">
                <span class="section-label">Toko Pilihan Anda</span>
                <h1 class="display-4 fw-bold text-gradient">Selamat Datang di TOKO BROD</h1>
                <p class="lead text-muted">Solusi belanja pintar untuk kebutuhan Anda. Temukan barang berkualitas dengan harga terbaik hanya di TOKO BROD.</p>
                <div class="hero-actions mt-4">
                    <a href="<?= BASE_URL; ?>user/produk.php" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-lift">
                        <i class="bi bi-bag me-1"></i> Mulai Belanja
                    </a>
                    <a href="<?= BASE_URL; ?>user/cek_pesanan.php" class="btn btn-outline-primary btn-lg rounded-pill shadow-sm hover-lift">
                        <i class="bi bi-search me-1"></i> Lacak Pesanan
                    </a>
                </div>
            </div>
            <div class="col-lg-6 hero-image-animate">
                <div class="hero-showcase">
                    <div class="showcase-card main float-animate">
                        <div class="icon-box"><i class="bi bi-basket2"></i></div>
                        <div>
                            <strong>Produk Terlengkap</strong>
                            <span>Pilihan bervariasi untuk semua.</span>
                        </div>
                    </div>
                    <div class="showcase-card float-animate delay-1">
                        <div class="icon-box"><i class="bi bi-lightning-charge"></i></div>
                        <div>
                            <strong>Transaksi Cepat</strong>
                            <span>Checkout tanpa ribet.</span>
                        </div>
                    </div>
                    <div class="showcase-card float-animate delay-2">
                        <div class="icon-box"><i class="bi bi-shield-check"></i></div>
                        <div>
                            <strong>Aman & Terpercaya</strong>
                            <span>Pantau pesanan setiap saat.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-label">Kategori</span>
                <h2>Kategori Produk</h2>
            </div>
            <a href="<?= BASE_URL; ?>user/produk.php" class="btn btn-light">Lihat semua</a>
        </div>
        <div class="category-grid">
            <?php foreach ($data['kategori'] as $kategori): ?>
                <a class="category-card" href="<?= BASE_URL; ?>user/produk.php?kategori_id=<?= $kategori['id']; ?>">
                    <i class="bi bi-tag"></i>
                    <strong><?= e($kategori['nama_kategori']); ?></strong>
                    <span><?= (int) $kategori['total_produk']; ?> produk</span>
                    <p><?= e(short_text($kategori['deskripsi'], 70)); ?></p>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="shop-section muted-section">
    <div class="container">
        <div class="section-heading">
            <div>
                <span class="section-label">Terbaru</span>
                <h2>Produk Terbaru</h2>
            </div>
            <a href="<?= BASE_URL; ?>user/produk.php" class="btn btn-primary">Belanja Sekarang</a>
        </div>
        <div class="product-grid">
            <?php foreach ($data['produkTerbaru'] as $produk): ?>
                <article class="product-card">
                    <div class="product-visual">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="product-body">
                        <span class="badge text-bg-light"><?= e($produk['nama_kategori'] ?? 'Tanpa Kategori'); ?></span>
                        <h3><?= e($produk['nama_produk']); ?></h3>
                        <p><?= e(short_text($produk['deskripsi'], 80)); ?></p>
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
                                    <i class="bi bi-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="shop-section">
    <div class="container">
        <div class="feature-grid">
            <div class="feature-card">
                <i class="bi bi-lightning-charge"></i>
                <h3>Belanja Cepat</h3>
                <p>Pelanggan cukup pilih produk, masukkan keranjang, lalu checkout.</p>
            </div>
            <div class="feature-card">
                <i class="bi bi-shield-check"></i>
                <h3>Data Terhubung</h3>
                <p>Produk dan kategori mengikuti data yang dikelola admin.</p>
            </div>
            <div class="feature-card">
                <i class="bi bi-clipboard-check"></i>
                <h3>Cek Pesanan</h3>
                <p>Status pesanan bisa dicek dari kode pesanan atau nomor HP.</p>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/user_footer.php'; ?>
