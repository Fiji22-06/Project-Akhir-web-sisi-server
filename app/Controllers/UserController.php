<?php
class UserController extends Controller {
    public function index() {
        if (customer_logged_in()) {
            header('Location: ' . BASE_URL . 'user/akun');
            exit;
        }

        $this->login();
    }

    public function login() {
        if (customer_logged_in()) {
            header('Location: ' . BASE_URL . 'user/akun');
            exit;
        }

        $error = $_SESSION['customer_login_error'] ?? null;
        unset($_SESSION['customer_login_error']);

        $this->view('user/login', ['error' => $error]);
    }

    public function proses() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'user/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('UserModel');
        $user = $userModel->findByUsername($username);

        if ($user && $user['role'] === 'user' && password_verify($password, $user['password'])) {
            $_SESSION['customer_logged_in'] = true;
            $_SESSION['customer'] = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            set_flash('success', 'Selamat datang, ' . $user['nama'] . '.');
            header('Location: ' . BASE_URL);
            exit;
        }

        $_SESSION['customer_login_error'] = 'Username atau password pelanggan salah.';
        header('Location: ' . BASE_URL . 'user/login');
        exit;
    }

    public function daftar() {
        if (customer_logged_in()) {
            header('Location: ' . BASE_URL . 'user/akun');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            $_SESSION['customer_register_old'] = [
                'nama' => $nama,
                'username' => $username,
            ];

            if ($nama === '' || $username === '' || $password === '' || $passwordConfirm === '') {
                $_SESSION['customer_register_error'] = 'Semua field wajib diisi.';
                header('Location: ' . BASE_URL . 'user/daftar');
                exit;
            }

            if (!preg_match('/^[A-Za-z0-9_]{3,50}$/', $username)) {
                $_SESSION['customer_register_error'] = 'Username minimal 3 karakter dan hanya boleh berisi huruf, angka, atau underscore.';
                header('Location: ' . BASE_URL . 'user/daftar');
                exit;
            }

            if (strlen($password) < 6) {
                $_SESSION['customer_register_error'] = 'Password minimal 6 karakter.';
                header('Location: ' . BASE_URL . 'user/daftar');
                exit;
            }

            if ($password !== $passwordConfirm) {
                $_SESSION['customer_register_error'] = 'Konfirmasi password tidak sama.';
                header('Location: ' . BASE_URL . 'user/daftar');
                exit;
            }

            $userModel = $this->model('UserModel');

            if ($userModel->usernameExists($username)) {
                $_SESSION['customer_register_error'] = 'Username sudah digunakan.';
                header('Location: ' . BASE_URL . 'user/daftar');
                exit;
            }

            if ($userModel->create($nama, $username, $password, 'user')) {
                unset($_SESSION['customer_register_old']);
                set_flash('success', 'Akun pelanggan berhasil dibuat. Silakan login.');
                header('Location: ' . BASE_URL . 'user/login');
                exit;
            }

            $_SESSION['customer_register_error'] = 'Akun pelanggan gagal dibuat.';
            header('Location: ' . BASE_URL . 'user/daftar');
            exit;
        }

        $error = $_SESSION['customer_register_error'] ?? null;
        $old = $_SESSION['customer_register_old'] ?? [];
        unset($_SESSION['customer_register_error'], $_SESSION['customer_register_old']);

        $this->view('user/daftar', [
            'error' => $error,
            'old' => $old,
        ]);
    }

    public function akun() {
        require_customer_login();
        $customer = get_customer();
        $pesananModel = $this->model('PesananModel');

        $this->view('user/akun', [
            'pageTitle' => 'Akun Saya',
            'activeUserPage' => 'akun',
            'customer' => $customer,
            'orders' => $pesananModel->getByUserId($customer['id']),
        ]);
    }

    public function logout() {
        unset($_SESSION['customer_logged_in'], $_SESSION['customer']);
        set_flash('success', 'Anda berhasil logout dari akun pelanggan.');
        header('Location: ' . BASE_URL);
        exit;
    }
}
