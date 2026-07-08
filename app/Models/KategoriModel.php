<?php
class KategoriModel {
    private $conn;

    public function __construct() {
        global $conn; // using the one from config/database.php
        $this->conn = $conn;
    }

    public function getAllWithCount() {
        $result = mysqli_query($this->conn, 
            'SELECT kategori.id, kategori.nama_kategori, kategori.deskripsi, COUNT(produk.id) AS total_produk
             FROM kategori
             LEFT JOIN produk ON produk.kategori_id = kategori.id AND produk.stok > 0
             GROUP BY kategori.id
             ORDER BY kategori.nama_kategori ASC'
        );
        
        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAll() {
        $result = mysqli_query($this->conn, 'SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC');
        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
