<?php
$pageTitle = 'Data Pengguna';
$activePage = 'pengguna';
require_once __DIR__ . '/../../templates/header.php';

$result = mysqli_query($conn, 'SELECT id, nama, username, role, created_at FROM users ORDER BY id DESC');

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pengguna</h3>
            <p>Kelola akun yang dapat mengakses sistem.</p>
        </div>
        <a href="<?= BASE_URL; ?>pages/pengguna/tambah.php" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Tambah Pengguna
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
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
                            <td><?= e($row['nama']); ?></td>
                            <td><?= e($row['username']); ?></td>
                            <td><span class="badge text-bg-primary"><?= e(ucfirst($row['role'])); ?></span></td>
                            <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>pages/pengguna/edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="<?= BASE_URL; ?>pages/pengguna/hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-delete" data-confirm="Yakin ingin menghapus pengguna ini?">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
