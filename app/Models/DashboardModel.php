<?php
class DashboardModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getStats() {
        $stats = [];
        $stats['totalPengguna'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, 'SELECT COUNT(*) AS total FROM users'))['total'];
        $stats['totalKategori'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, 'SELECT COUNT(*) AS total FROM kategori'))['total'];
        $stats['totalProduk'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, 'SELECT COUNT(*) AS total FROM produk'))['total'];
        $stats['totalStok'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, 'SELECT COALESCE(SUM(stok), 0) AS total FROM produk'))['total'];
        $stats['totalPesanan'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, 'SELECT COUNT(*) AS total FROM pesanan'))['total'];
        $stats['totalPendapatan'] = (float) mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COALESCE(SUM(total_harga), 0) AS total FROM pesanan WHERE status_pesanan = 'Selesai'"))['total'];
        $stats['pesananMenunggu'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status_pesanan = 'Menunggu'"))['total'];
        $stats['pesananSelesai'] = (int) mysqli_fetch_assoc(mysqli_query($this->conn, "SELECT COUNT(*) AS total FROM pesanan WHERE status_pesanan = 'Selesai'"))['total'];
        
        return $stats;
    }
}
