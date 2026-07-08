<?php
class UserModel {
    private $conn;
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    public function findByUsername($username) {
        $stmt = mysqli_prepare($this->conn, 'SELECT id, nama, username, password, role FROM users WHERE username = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    public function usernameExists($username) {
        $stmt = mysqli_prepare($this->conn, 'SELECT id FROM users WHERE username = ? LIMIT 1');
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result) > 0;
    }

    public function create($nama, $username, $password, $role = 'user') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = mysqli_prepare($this->conn, 'INSERT INTO users (nama, username, password, role) VALUES (?, ?, ?, ?)');
        mysqli_stmt_bind_param($stmt, 'ssss', $nama, $username, $hashedPassword, $role);
        return mysqli_stmt_execute($stmt);
    }
}
