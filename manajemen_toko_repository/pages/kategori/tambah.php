<?php
$pageTitle = 'Tambah Kategori';
$activePage = 'kategori';
require_once __DIR__ . '/../../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaKategori = trim($_POST['nama_kategori'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($namaKategori === '') {
        set_flash('danger', 'Nama kategori wajib diisi.');
    } else {
        $stmt = mysqli_prepare($conn, 'INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)');
        mysqli_stmt_bind_param($stmt, 'ss', $namaKategori, $deskripsi);

        if (mysqli_stmt_execute($stmt)) {
            set_flash('success', 'Kategori berhasil ditambahkan.');
            header('Location: ' . BASE_URL . 'pages/kategori/index.php');
            exit;
        }

        set_flash('danger', 'Kategori gagal ditambahkan.');
    }
}

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Tambah Kategori</h3>
            <p>Isi nama kategori dan keterangan singkat.</p>
        </div>
    </div>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?= e($_POST['nama_kategori'] ?? ''); ?>" required>
        </div>
        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= e($_POST['deskripsi'] ?? ''); ?></textarea>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pages/kategori/index.php" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
