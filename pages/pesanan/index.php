<?php
$pageTitle = 'Data Pesanan';
$activePage = 'pesanan';
require_once __DIR__ . '/../../templates/header.php';

$result = mysqli_query($conn, 'SELECT id, kode_pesanan, nama_pelanggan, no_hp, total_harga, status_pesanan, created_at FROM pesanan ORDER BY id DESC');

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Pesanan</h3>
            <p>Pantau pesanan pelanggan dan kelola statusnya.</p>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pesanan</th>
                    <th>Nama Pelanggan</th>
                    <th>Nomor HP</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= e($row['kode_pesanan']); ?></strong></td>
                            <td><?= e($row['nama_pelanggan']); ?></td>
                            <td><?= e($row['no_hp']); ?></td>
                            <td><?= rupiah($row['total_harga']); ?></td>
                            <td><span class="badge <?= status_badge_class($row['status_pesanan']); ?>"><?= e($row['status_pesanan']); ?></span></td>
                            <td><?= date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>pages/pesanan/detail.php?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="<?= BASE_URL; ?>pages/pesanan/edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Status
                                </a>
                                <a href="<?= BASE_URL; ?>pages/pesanan/hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-delete" data-confirm="Yakin ingin menghapus pesanan ini?">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
