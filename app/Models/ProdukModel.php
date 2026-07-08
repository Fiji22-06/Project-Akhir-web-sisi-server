<?php
class ProdukModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getLatest($limit = 6) {
        $limit = (int) $limit;
        $result = mysqli_query($this->conn, 
            "SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, produk.deskripsi, kategori.nama_kategori
             FROM produk
             LEFT JOIN kategori ON kategori.id = produk.kategori_id
             WHERE produk.stok > 0
             ORDER BY produk.id DESC
             LIMIT $limit"
        );
        
        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getAllFiltered($keyword, $kategoriId) {
        $sql = 'SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, produk.deskripsi, kategori.nama_kategori
                FROM produk
                LEFT JOIN kategori ON kategori.id = produk.kategori_id
                WHERE produk.stok > 0';
        $types = '';
        $params = [];

        if ($keyword !== '') {
            $sql .= ' AND produk.nama_produk LIKE ?';
            $types .= 's';
            $params[] = '%' . $keyword . '%';
        }

        if ($kategoriId > 0) {
            $sql .= ' AND produk.kategori_id = ?';
            $types .= 'i';
            $params[] = $kategoriId;
        }

        $sql .= ' ORDER BY produk.id DESC';
        $result = prepared_query($this->conn, $sql, $types, $params);
        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getById($id) {
        $result = prepared_query(
            $this->conn,
            'SELECT produk.*, kategori.nama_kategori
             FROM produk
             LEFT JOIN kategori ON kategori.id = produk.kategori_id
             WHERE produk.id = ?',
            'i',
            [$id]
        );
        return mysqli_fetch_assoc($result);
    }

    public function getAvailableById($id) {
        $result = prepared_query(
            $this->conn,
            'SELECT produk.*, kategori.nama_kategori
             FROM produk
             LEFT JOIN kategori ON kategori.id = produk.kategori_id
             WHERE produk.id = ? AND produk.stok > 0',
            'i',
            [$id]
        );
        return mysqli_fetch_assoc($result);
    }
}
