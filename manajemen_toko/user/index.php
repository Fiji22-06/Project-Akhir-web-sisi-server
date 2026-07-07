<?php
$pageTitle = 'Beranda';
$activeUserPage = 'home';
require_once __DIR__ . '/../templates/user_header.php';

$kategoriResult = mysqli_query(
    $conn,
    'SELECT kategori.id, kategori.nama_kategori, kategori.deskripsi, COUNT(produk.id) AS total_produk
     FROM kategori
     LEFT JOIN produk ON produk.kategori_id = kategori.id
     GROUP BY kategori.id
     ORDER BY kategori.nama_kategori ASC'
);

$produkTerbaru = mysqli_query(
    $conn,
    'SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, produk.deskripsi, kategori.nama_kategori
     FROM produk
     LEFT JOIN kategori ON kategori.id = produk.kategori_id
     ORDER BY produk.id DESC
     LIMIT 6'
);
?>
<section class="shop-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <span class="section-label">Toko Online</span>
                <h1>Selamat Datang di Toko Online</h1>
                <p>Temukan produk pilihan toko dengan proses belanja yang mudah, cepat, dan bisa dicek status pesanannya kapan saja.</p>
                <div class="hero-actions">
                    <a href="<?= BASE_URL; ?>user/produk.php" class="btn btn-primary btn-lg">
                        <i class="bi bi-bag me-1"></i> Lihat Produk
                    </a>
                    <a href="<?= BASE_URL; ?>user/cek_pesanan.php" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-search me-1"></i> Cek Pesanan
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-showcase">
                    <div class="showcase-card main">
                        <i class="bi bi-basket2"></i>
                        <strong>Produk siap dipesan</strong>
                        <span>Katalog terhubung langsung dengan data admin.</span>
                    </div>
                    <div class="showcase-card">
                        <i class="bi bi-receipt"></i>
                        <strong>Checkout mudah</strong>
                        <span>Isi data diri tanpa membuat akun.</span>
                    </div>
                    <div class="showcase-card">
                        <i class="bi bi-truck"></i>
                        <strong>Status transparan</strong>
                        <span>Cek pesanan dari kode atau nomor HP.</span>
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
            <?php while ($kategori = mysqli_fetch_assoc($kategoriResult)): ?>
                <a class="category-card" href="<?= BASE_URL; ?>user/produk.php?kategori_id=<?= $kategori['id']; ?>">
                    <i class="bi bi-tag"></i>
                    <strong><?= e($kategori['nama_kategori']); ?></strong>
                    <span><?= (int) $kategori['total_produk']; ?> produk</span>
                    <p><?= e(short_text($kategori['deskripsi'], 70)); ?></p>
                </a>
            <?php endwhile; ?>
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
            <?php while ($produk = mysqli_fetch_assoc($produkTerbaru)): ?>
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
            <?php endwhile; ?>
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
<?php require_once __DIR__ . '/../templates/user_footer.php'; ?>
