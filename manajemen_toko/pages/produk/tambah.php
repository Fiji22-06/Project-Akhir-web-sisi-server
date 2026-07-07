<?php
$pageTitle = 'Tambah Produk';
$activePage = 'produk';
require_once __DIR__ . '/../../templates/header.php';

$kategoriResult = mysqli_query($conn, 'SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaProduk = trim($_POST['nama_produk'] ?? '');
    $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
    $harga = (float) ($_POST['harga'] ?? 0);
    $stok = (int) ($_POST['stok'] ?? 0);
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($namaProduk === '' || $kategoriId <= 0 || $harga < 0 || $stok < 0) {
        set_flash('danger', 'Nama produk, kategori, harga, dan stok wajib diisi dengan benar.');
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO produk (nama_produk, kategori_id, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'sidis', $namaProduk, $kategoriId, $harga, $stok, $deskripsi);

        if (mysqli_stmt_execute($stmt)) {
            set_flash('success', 'Produk berhasil ditambahkan.');
            header('Location: ' . BASE_URL . 'pages/produk/index.php');
            exit;
        }

        set_flash('danger', 'Produk gagal ditambahkan.');
    }
}

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Tambah Produk</h3>
            <p>Masukkan produk baru ke inventori toko.</p>
        </div>
    </div>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= e($_POST['nama_produk'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                <option value="">Pilih kategori</option>
                <?php while ($kategori = mysqli_fetch_assoc($kategoriResult)): ?>
                    <option value="<?= $kategori['id']; ?>" <?= (int) ($_POST['kategori_id'] ?? 0) === (int) $kategori['id'] ? 'selected' : ''; ?>>
                        <?= e($kategori['nama_kategori']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" min="0" step="100" value="<?= e($_POST['harga'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" min="0" value="<?= e($_POST['stok'] ?? ''); ?>" required>
        </div>
        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= e($_POST['deskripsi'] ?? ''); ?></textarea>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pages/produk/index.php" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
