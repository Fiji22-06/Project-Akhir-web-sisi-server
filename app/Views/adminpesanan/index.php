<?php
$pageTitle = $data['pageTitle'] ?? 'Data Pesanan';
$activePage = $data['activePage'] ?? 'pesanan';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$orders = $data['orders'];
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
                <?php if (count($orders) > 0): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($orders as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= e($row['kode_pesanan']); ?></strong></td>
                            <td><?= e($row['nama_pelanggan']); ?></td>
                            <td><?= e($row['no_hp']); ?></td>
                            <td><?= rupiah($row['total_harga']); ?></td>
                            <td><span class="badge <?= status_badge_class($row['status_pesanan']); ?>"><?= e($row['status_pesanan']); ?></span></td>
                            <td><?= date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>adminpesanan/detail?id=<?= $row['id']; ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="<?= BASE_URL; ?>adminpesanan/edit?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Status
                                </a>
                                <form action="<?= BASE_URL; ?>adminpesanan/hapus" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus pesanan ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Belum ada data pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
