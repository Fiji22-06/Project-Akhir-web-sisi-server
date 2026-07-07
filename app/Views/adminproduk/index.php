<?php
$pageTitle = $data['pageTitle'] ?? 'Data Produk';
$activePage = $data['activePage'] ?? 'produk';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$products = $data['products'];
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Produk</h3>
            <p>Kelola barang yang dijual di toko.</p>
        </div>
        <a href="<?= BASE_URL; ?>adminproduk/tambah" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Tambah Produk
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php $no = 1; ?>
                    <?php foreach ($products as $row): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><strong><?= e($row['nama_produk']); ?></strong></td>
                            <td><span class="badge text-bg-light"><?= e($row['nama_kategori'] ?? 'Tanpa Kategori'); ?></span></td>
                            <td><?= rupiah($row['harga']); ?></td>
                            <td>
                                <?php if ((int) $row['stok'] <= 5): ?>
                                    <span class="badge text-bg-danger"><?= (int) $row['stok']; ?></span>
                                <?php else: ?>
                                    <?= (int) $row['stok']; ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>adminproduk/edit?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="<?= BASE_URL; ?>adminproduk/hapus" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm btn-delete" onclick="return confirm('Yakin ingin menghapus produk ini?');">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada data produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
