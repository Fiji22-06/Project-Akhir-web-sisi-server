<?php
$pageTitle = 'Edit Pengguna';
$activePage = 'pengguna';
require_once __DIR__ . '/../../templates/header.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, 'SELECT id, nama, username, role FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$pengguna = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$pengguna) {
    set_flash('danger', 'Data pengguna tidak ditemukan.');
    header('Location: ' . BASE_URL . 'pages/pengguna/index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'staff';

    if ($nama === '' || $username === '' || !in_array($role, ['admin', 'staff'], true)) {
        set_flash('danger', 'Nama, username, dan role wajib diisi dengan benar.');
    } else {
        $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1');
        mysqli_stmt_bind_param($check, 'si', $username, $id);
        mysqli_stmt_execute($check);
        $exists = mysqli_stmt_get_result($check);

        if (mysqli_num_rows($exists) > 0) {
            set_flash('danger', 'Username sudah digunakan pengguna lain.');
        } else {
            if ($password !== '') {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $update = mysqli_prepare($conn, 'UPDATE users SET nama = ?, username = ?, password = ?, role = ? WHERE id = ?');
                mysqli_stmt_bind_param($update, 'ssssi', $nama, $username, $hashedPassword, $role, $id);
            } else {
                $update = mysqli_prepare($conn, 'UPDATE users SET nama = ?, username = ?, role = ? WHERE id = ?');
                mysqli_stmt_bind_param($update, 'sssi', $nama, $username, $role, $id);
            }

            if (mysqli_stmt_execute($update)) {
                if ((int) $_SESSION['user']['id'] === $id) {
                    $_SESSION['user']['nama'] = $nama;
                    $_SESSION['user']['username'] = $username;
                    $_SESSION['user']['role'] = $role;
                }

                set_flash('success', 'Pengguna berhasil diperbarui.');
                header('Location: ' . BASE_URL . 'pages/pengguna/index.php');
                exit;
            }

            set_flash('danger', 'Pengguna gagal diperbarui.');
        }
    }
}

require_once __DIR__ . '/../../templates/sidebar.php';
?>
<section class="form-panel">
    <div class="panel-header">
        <div>
            <h3>Edit Pengguna</h3>
            <p>Kosongkan password jika tidak ingin mengubahnya.</p>
        </div>
    </div>

    <form method="post" class="row g-3">
        <div class="col-md-6">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?= e($_POST['nama'] ?? $pengguna['nama']); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?= e($_POST['username'] ?? $pengguna['username']); ?>" required>
        </div>
        <div class="col-md-6">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika tidak diganti">
        </div>
        <div class="col-md-6">
            <label for="role" class="form-label">Role</label>
            <?php $selectedRole = $_POST['role'] ?? $pengguna['role']; ?>
            <select name="role" id="role" class="form-select" required>
                <option value="admin" <?= $selectedRole === 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="staff" <?= $selectedRole === 'staff' ? 'selected' : ''; ?>>Staff</option>
            </select>
        </div>
        <div class="col-12 form-actions">
            <a href="<?= BASE_URL; ?>pages/pengguna/index.php" class="btn btn-light">Batal</a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-pencil-square me-1"></i> Update
            </button>
        </div>
    </form>
</section>
<?php require_once __DIR__ . '/../../templates/footer.php'; ?>
