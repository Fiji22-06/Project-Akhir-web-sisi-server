<?php
class AuthController extends Controller {
    public function index() {
        $this->login();
    }

    public function login() {
        if (!empty($_SESSION['logged_in'])) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }
        $error = $_SESSION['login_error'] ?? null;
        unset($_SESSION['login_error']);
        $this->view('auth/login', ['error' => $error]);
    }

    public function proses() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'auth/login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('UserModel');
        $user = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $_SESSION['login_error'] = 'Username atau password salah';
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . 'auth/login');
        exit;
    }
}
