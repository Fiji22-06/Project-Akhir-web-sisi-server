<?php
$pageTitle = 'Data Kategori';
$activePage = 'kategori';
require_once __DIR__ . '/../../templates/header.php';

$result = mysqli_query($conn, 'SELECT id, nama_kategori, deskripsi, created_at FROM kategori ORDER BY id DESC');

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Kategori</h3>
            <p>Kelompokkan produk agar data lebih mudah dibaca.</p>
        </div>
        <a href="<?= BASE_URL; ?>pages/kategori/tambah.php" class="btn btn-success">
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
                    <th>Dibuat</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= e($row['nama_kategori']); ?></td>
                            <td><?= e($row['deskripsi']); ?></td>
                            <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>pages/kategori/edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="<?= BASE_URL; ?>pages/kategori/hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-delete" data-confirm="Yakin ingin menghapus kategori ini?">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data kategori.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
