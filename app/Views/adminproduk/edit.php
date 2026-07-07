<?php
$pageTitle = $data['pageTitle'] ?? 'Edit Produk';
$activePage = $data['activePage'] ?? 'produk';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$produk = $data['produk'];
$categories = $data['categories'];
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Edit Produk</h3>
            <p>Perbarui informasi produk toko.</p>
        </div>
    </div>

    <form method="post" action="<?= BASE_URL; ?>adminproduk/edit?id=<?= $produk['id']; ?>" class="row g-3">
        <div class="col-md-6">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" id="nama_produk" class="form-control" value="<?= e($_POST['nama_produk'] ?? $produk['nama_produk']); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="kategori_id" class="form-label">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="form-select" required>
                <option value="">Pilih kategori</option>
                <?php foreach ($categories as $kategori): ?>
                    <option value="<?= $kategori['id']; ?>" <?= (int) ($_POST['kategori_id'] ?? $produk['kategori_id']) === (int) $kategori['id'] ? 'selected' : ''; ?>>
                        <?= e($kategori['nama_kategori']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" min="0" step="100" value="<?= e($_POST['harga'] ?? (float) $produk['harga']); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" min="0" value="<?= e($_POST['stok'] ?? (int) $produk['stok']); ?>" required>
        </div>
        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= e($_POST['deskripsi'] ?? $produk['deskripsi']); ?></textarea>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>adminproduk" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
