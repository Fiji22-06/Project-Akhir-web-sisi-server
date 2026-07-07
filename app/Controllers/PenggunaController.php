<?php
class PenggunaController extends Controller {
    public function index() {
        require_login();
        global $conn;
        $result = mysqli_query($conn, 'SELECT id, nama, username, role, created_at FROM users ORDER BY id DESC');
        $users = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        }
        $this->view('pengguna/index', [
            'pageTitle' => 'Data Pengguna',
            'activePage' => 'pengguna',
            'users' => $users
        ]);
    }

    public function tambah() {
        require_login();
        global $conn;

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
                        header('Location: ' . BASE_URL . 'pengguna');
                        exit;
                    }
                    set_flash('danger', 'Pengguna gagal ditambahkan.');
                }
            }
        }

        $this->view('pengguna/tambah', [
            'pageTitle' => 'Tambah Pengguna',
            'activePage' => 'pengguna'
        ]);
    }

    public function edit() {
        require_login();
        global $conn;

        $id = (int) ($_GET['id'] ?? 0);
        $user_data = mysqli_fetch_assoc(prepared_query($conn, 'SELECT id, nama, username, role FROM users WHERE id = ?', 'i', [$id]));

        if (!$user_data) {
            set_flash('danger', 'Pengguna tidak ditemukan.');
            header('Location: ' . BASE_URL . 'pengguna');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'staff';

            if ($nama === '' || $username === '' || !in_array($role, ['admin', 'staff'], true)) {
                set_flash('danger', 'Field nama, username, dan role wajib diisi.');
            } else {
                $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE username = ? AND id != ? LIMIT 1');
                mysqli_stmt_bind_param($check, 'si', $username, $id);
                mysqli_stmt_execute($check);
                $exists = mysqli_stmt_get_result($check);

                if (mysqli_num_rows($exists) > 0) {
                    set_flash('danger', 'Username sudah digunakan oleh pengguna lain.');
                } else {
                    if ($password !== '') {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = mysqli_prepare($conn, 'UPDATE users SET nama = ?, username = ?, password = ?, role = ? WHERE id = ?');
                        mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $username, $hashedPassword, $role, $id);
                    } else {
                        $stmt = mysqli_prepare($conn, 'UPDATE users SET nama = ?, username = ?, role = ? WHERE id = ?');
                        mysqli_stmt_bind_param($stmt, 'sssi', $nama, $username, $role, $id);
                    }

                    if (mysqli_stmt_execute($stmt)) {
                        set_flash('success', 'Pengguna berhasil diperbarui.');
                        header('Location: ' . BASE_URL . 'pengguna');
                        exit;
                    }
                    set_flash('danger', 'Pengguna gagal diperbarui.');
                }
            }
        }

        $this->view('pengguna/edit', [
            'pageTitle' => 'Edit Pengguna',
            'activePage' => 'pengguna',
            'user_data' => $user_data
        ]);
    }

    public function hapus() {
        require_login();
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id'] ?? 0);
            
            if ($id === (int) $_SESSION['user']['id']) {
                set_flash('danger', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
            } else {
                $stmt = mysqli_prepare($conn, 'DELETE FROM users WHERE id = ?');
                mysqli_stmt_bind_param($stmt, 'i', $id);
                if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
                    set_flash('success', 'Pengguna berhasil dihapus.');
                } else {
                    set_flash('danger', 'Gagal menghapus pengguna atau pengguna tidak ditemukan.');
                }
            }
        }

        header('Location: ' . BASE_URL . 'pengguna');
        exit;
    }
}
