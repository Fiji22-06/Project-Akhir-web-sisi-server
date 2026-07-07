<?php
$pageTitle = $data['pageTitle'] ?? 'Edit Kategori';
$activePage = $data['activePage'] ?? 'kategori';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$kategori = $data['kategori'];
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Edit Kategori</h3>
            <p>Perbarui informasi kategori produk.</p>
        </div>
    </div>

    <form method="post" action="<?= BASE_URL; ?>kategori/edit?id=<?= $kategori['id']; ?>" class="row g-3">
        <div class="col-md-12">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?= e($_POST['nama_kategori'] ?? $kategori['nama_kategori']); ?>" required>
        </div>
        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= e($_POST['deskripsi'] ?? $kategori['deskripsi']); ?></textarea>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>kategori" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
