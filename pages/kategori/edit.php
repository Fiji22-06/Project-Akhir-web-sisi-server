<?php
$pageTitle = 'Edit Kategori';
$activePage = 'kategori';
require_once __DIR__ . '/../../templates/header.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT id, nama_kategori, deskripsi FROM kategori WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$kategori = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$kategori) {
    set_flash('danger', 'Data kategori tidak ditemukan.');
    header('Location: ' . BASE_URL . 'pages/kategori/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaKategori = trim($_POST['nama_kategori'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');

    if ($namaKategori === '') {
        set_flash('danger', 'Nama kategori wajib diisi.');
    } else {
        $update = mysqli_prepare($conn, 'UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id = ?');
        mysqli_stmt_bind_param($update, 'ssi', $namaKategori, $deskripsi, $id);

        if (mysqli_stmt_execute($update)) {
            set_flash('success', 'Kategori berhasil diperbarui.');
            header('Location: ' . BASE_URL . 'pages/kategori/index.php');
            exit;
        }

        set_flash('danger', 'Kategori gagal diperbarui.');
    }
}

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Edit Kategori</h3>
            <p>Perbarui informasi kategori.</p>
        </div>
    </div>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" value="<?= e($_POST['nama_kategori'] ?? $kategori['nama_kategori']); ?>" required>
        </div>
        <div class="col-12">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"><?= e($_POST['deskripsi'] ?? $kategori['deskripsi']); ?></textarea>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pages/kategori/index.php" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
