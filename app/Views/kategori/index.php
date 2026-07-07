<?php
$pageTitle = $data['pageTitle'] ?? 'Data Kategori';
$activePage = $data['activePage'] ?? 'kategori';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$categories = $data['categories'];
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Kategori</h3>
            <p>Kelola kelompok produk toko.</p>
        </div>
        <a href="<?= BASE_URL; ?>kategori/tambah" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Tambah Kategori
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($categories) > 0): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($categories as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= e($row['nama_kategori']); ?></strong></td>
                            <td><?= e(short_text($row['deskripsi'], 60)); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>kategori/edit?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="<?= BASE_URL; ?>kategori/hapus" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus kategori ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada data kategori.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
