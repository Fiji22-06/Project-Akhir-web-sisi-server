<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'auth/login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = mysqli_prepare($conn, 'SELECT id, nama, username, password, role FROM users WHERE username = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nama' => $user['nama'],
        'username' => $user['username'],
        'role' => $user['role'],
    ];

    header('Location: ' . BASE_URL . 'pages/dashboard.php');
    exit;
}

$_SESSION['login_error'] = 'Username atau password salah';
header('Location: ' . BASE_URL . 'auth/login.php');
exit;
