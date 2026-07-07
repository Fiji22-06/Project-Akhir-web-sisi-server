<?php
$pageTitle = 'Tambah Pengguna';
$activePage = 'pengguna';
require_once __DIR__ . '/../../templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'staff';

    if ($nama === '' || $username === '' || $password === '' || !in_array($role, ['admin', 'staff'], true)) {
        set_flash('danger', 'Semua field wajib diisi dengan benar.');
    } else {
        $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? LIMIT 1');
        mysqli_stmt_bind_param($check, 's', $username);
        mysqli_stmt_execute($check);
        $exists = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($exists) > 0) {
            set_flash('danger', 'Username sudah digunakan.');
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, 'INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssss', $nama, $username, $hashedPassword, $role);

            if (mysqli_stmt_execute($stmt)) {
                set_flash('success', 'Pengguna berhasil ditambahkan.');
                header('Location: ' . BASE_URL . 'pages/pengguna/index.php');
                exit;
            }

            set_flash('danger', 'Pengguna gagal ditambahkan.');
        }
    }
}

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Tambah Pengguna</h3>
            <p>Lengkapi data akun baru.</p>
        </div>
    </div>

    <form method="post" class="row g-3">
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
            </select>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pages/pengguna/index.php" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
