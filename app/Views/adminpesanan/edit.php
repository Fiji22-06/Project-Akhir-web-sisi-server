<?php
$pageTitle = $data['pageTitle'] ?? 'Edit Status Pesanan';
$activePage = $data['activePage'] ?? 'pesanan';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
$pesanan = $data['pesanan'];
$statusList = $data['statusList'];
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Edit Status Pesanan</h3>
            <p>Ubah status untuk pesanan <?= e($pesanan['kode_pesanan']); ?>.</p>
        </div>
    </div>

    <form method="post" action="<?= BASE_URL; ?>adminpesanan/edit?id=<?= $pesanan['id']; ?>" class="row g-3">
        <div class="col-md-6">
            <label for="status_pesanan" class="form-label">Status Pesanan</label>
            <?php $selectedStatus = $_POST['status_pesanan'] ?? $pesanan['status_pesanan']; ?>
            <select name="status_pesanan" id="status_pesanan" class="form-select" required>
                <?php foreach ($statusList as $status): ?>
                    <option value="<?= e($status); ?>" <?= $selectedStatus === $status ? 'selected' : ''; ?>>
                        <?= e($status); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>adminpesanan" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i> Update Status
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
