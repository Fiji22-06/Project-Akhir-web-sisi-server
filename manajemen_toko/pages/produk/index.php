<?php
$pageTitle = 'Data Produk';
$activePage = 'produk';
require_once __DIR__ . '/../../templates/header.php';

$query = "SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, produk.deskripsi, produk.created_at, kategori.nama_kategori
          FROM produk
          LEFT JOIN kategori ON kategori.id = produk.kategori_id
          ORDER BY produk.id DESC";
$result = mysqli_query($conn, $query);

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="data-panel">
    <div class="panel-header">
        <div>
            <h3>Daftar Produk</h3>
            <p>Lihat stok, harga, dan kategori produk.</p>
        </div>
        <a href="<?= BASE_URL; ?>pages/produk/tambah.php" class="btn btn-success">
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
                    <th>Deskripsi</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= e($row['nama_produk']); ?></td>
                            <td><span class="badge text-bg-light"><?= e($row['nama_kategori'] ?? 'Tanpa Kategori'); ?></span></td>
                            <td><?= rupiah($row['harga']); ?></td>
                            <td><?= (int) $row['stok']; ?></td>
                            <td><?= e($row['deskripsi']); ?></td>
                            <td class="text-end">
                                <a href="<?= BASE_URL; ?>pages/produk/edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="<?= BASE_URL; ?>pages/produk/hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm btn-delete" data-confirm="Yakin ingin menghapus produk ini?">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">Belum ada data produk.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
