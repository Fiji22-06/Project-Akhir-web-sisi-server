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
}
