<?php
$pageTitle = $data['pageTitle'] ?? 'Data Pengguna';
$activePage = $data['activePage'] ?? 'pengguna';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$users = $data['users'];
$roleBadges = [
    'admin' => 'text-bg-primary',
    'staff' => 'text-bg-info',
    'user' => 'text-bg-success',
];
$roleLabels = [
    'admin' => 'Admin',
    'staff' => 'Staff',
    'user' => 'User Pelanggan',
];
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pengguna</h3>
            <p>Kelola akun yang dapat mengakses sistem.</p>
        </div>
        <a href="<?= BASE_URL; ?>pengguna/tambah" class="btn btn-success">
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
                <?php if (count($users) > 0): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($users as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= e($row['nama']); ?></td>
                            <td><?= e($row['username']); ?></td>
                            <td><span class="badge <?= e($roleBadges[$row['role']] ?? 'text-bg-secondary'); ?>"><?= e($roleLabels[$row['role']] ?? ucfirst($row['role'])); ?></span></td>
                            <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>pengguna/edit?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="<?= BASE_URL; ?>pengguna/hapus" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus pengguna ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
