<?php
$pageTitle = $data['pageTitle'] ?? 'Tambah Pengguna';
$activePage = $data['activePage'] ?? 'pengguna';
require_once __DIR__ . '/../../../templates/header.php';
require_once __DIR__ . '/../../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Tambah Pengguna</h3>
            <p>Lengkapi data akun baru.</p>
        </div>
    </div>

    <form method="post" action="<?= BASE_URL; ?>pengguna/tambah" class="row g-3">
        <div class="col-md-6">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= e($_POST['nama'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= e($_POST['username'] ?? ''); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required>
                <?php $selectedRole = $_POST['role'] ?? 'staff'; ?>
                <option value="admin" <?= $selectedRole === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="staff" <?= $selectedRole === 'staff' ? 'selected' : ''; ?>>Staff</option>
                <option value="user" <?= $selectedRole === 'user' ? 'selected' : ''; ?>>User Pelanggan</option>
            </select>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pengguna" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../../templates/footer.php'; ?>
