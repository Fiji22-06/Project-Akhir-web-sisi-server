<?php
$pageTitle = 'Edit Produk';
$activePage = 'produk';
require_once __DIR__ . '/../../templates/header.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT id, nama_produk, kategori_id, harga, stok, deskripsi FROM produk WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$produk = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$produk) {
    set_flash('danger', 'Data produk tidak ditemukan.');
    header('Location: ' . BASE_URL . 'pages/produk/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaProduk = trim($_POST['nama_produk'] ?? '');
    $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
    $harga = (float) ($_POST['harga'] ?? 0);
    $stok = (int) ($_POST['stok'] ?? 0);
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($namaProduk === '' || $kategoriId <= 0 || $harga < 0 || $stok < 0) {
        set_flash('danger', 'Nama produk, kategori, harga, dan stok wajib diisi dengan benar.');
    } else {
        $update = mysqli_prepare($conn, 'UPDATE produk SET nama_produk = ?, kategori_id = ?, harga = ?, stok = ?, deskripsi = ? WHERE id = ?');
        mysqli_stmt_bind_param($update, 'sidisi', $namaProduk, $kategoriId, $harga, $stok, $deskripsi, $id);

        if (mysqli_stmt_execute($update)) {
            set_flash('success', 'Produk berhasil diperbarui.');
            header('Location: ' . BASE_URL . 'pages/produk/index.php');
            exit;
        }

        set_flash('danger', 'Produk gagal diperbarui.');
    }
}

$kategoriResult = mysqli_query($conn, 'SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC');

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Edit Produk</h3>
            <p>Perbarui data produk toko.</p>
        </div>
    </div>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= e($_POST['nama_produk'] ?? $produk['nama_produk']); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="kategori_id" class="form-label">Kategori</label>
            <?php $selectedKategori = (int) ($_POST['kategori_id'] ?? $produk['kategori_id']); ?>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                <option value="">Pilih kategori</option>
                <?php while ($kategori = mysqli_fetch_assoc($kategoriResult)): ?>
                    <option value="<?= $kategori['id']; ?>" <?= $selectedKategori === (int) $kategori['id'] ? 'selected' : ''; ?>>
                        <?= e($kategori['nama_kategori']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" min="0" step="100" value="<?= e($_POST['harga'] ?? $produk['harga']); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" min="0" value="<?= e($_POST['stok'] ?? $produk['stok']); ?>" required>
        </div>
        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= e($_POST['deskripsi'] ?? $produk['deskripsi']); ?></textarea>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pages/produk/index.php" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
