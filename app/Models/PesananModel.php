<?php
class PesananModel {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function createPesanan($nama, $noHp, $alamat, $metode, $cart, $userId = null) {
        mysqli_begin_transaction($this->conn);
        try {
            $status = 'Menunggu';
            $userId = $userId ? (int) $userId : null;
            $insertPesanan = mysqli_prepare(
                $this->conn,
                'INSERT INTO pesanan (user_id, kode_pesanan, nama_pelanggan, no_hp, alamat, metode_pembayaran, total_harga, status_pesanan)
                 VALUES (?, NULL, ?, ?, ?, ?, ?, ?)'
            );
            mysqli_stmt_bind_param($insertPesanan, 'issssds', $userId, $nama, $noHp, $alamat, $metode, $cart['total'], $status);

            if (!mysqli_stmt_execute($insertPesanan)) {
                throw new Exception('Gagal menyimpan pesanan.');
            }

            $pesananId = mysqli_insert_id($this->conn);
            $kodePesanan = 'ORD' . str_pad((string) $pesananId, 4, '0', STR_PAD_LEFT);

            $updateKode = mysqli_prepare($this->conn, 'UPDATE pesanan SET kode_pesanan = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateKode, 'si', $kodePesanan, $pesananId);

            if (!mysqli_stmt_execute($updateKode)) {
                throw new Exception('Gagal membuat kode pesanan.');
            }

            $insertDetail = mysqli_prepare(
                $this->conn,
                'INSERT INTO detail_pesanan (pesanan_id, produk_id, jumlah, harga, subtotal) VALUES (?, ?, ?, ?, ?)'
            );
            $decreaseStock = mysqli_prepare(
                $this->conn,
                'UPDATE produk SET stok = stok - ? WHERE id = ? AND stok >= ?'
            );

            foreach ($cart['items'] as $item) {
                $produkId = (int) $item['produk']['id'];
                $jumlah = (int) $item['jumlah'];
                $harga = (float) $item['produk']['harga'];
                $subtotal = (float) $item['subtotal'];

                mysqli_stmt_bind_param($decreaseStock, 'iii', $jumlah, $produkId, $jumlah);

                if (!mysqli_stmt_execute($decreaseStock) || mysqli_stmt_affected_rows($decreaseStock) < 1) {
                    throw new Exception('Stok produk tidak mencukupi.');
                }

                mysqli_stmt_bind_param($insertDetail, 'iiidd', $pesananId, $produkId, $jumlah, $harga, $subtotal);

                if (!mysqli_stmt_execute($insertDetail)) {
                    throw new Exception('Gagal menyimpan detail pesanan.');
                }
            }

            mysqli_commit($this->conn);
            return $kodePesanan;
        } catch (Throwable $error) {
            mysqli_rollback($this->conn);
            return false;
        }
    }

    public function cariPesanan($keyword) {
        $likeKeyword = '%' . $keyword . '%';
        $result = prepared_query(
            $this->conn,
            'SELECT id, kode_pesanan, nama_pelanggan, no_hp, total_harga, status_pesanan, created_at
             FROM pesanan
             WHERE kode_pesanan = ? OR no_hp LIKE ?
             ORDER BY id DESC',
            'ss',
            [$keyword, $likeKeyword]
        );
        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getByUserId($userId) {
        $result = prepared_query(
            $this->conn,
            'SELECT id, kode_pesanan, nama_pelanggan, no_hp, total_harga, status_pesanan, created_at
             FROM pesanan
             WHERE user_id = ?
             ORDER BY id DESC
             LIMIT 10',
            'i',
            [(int) $userId]
        );
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getByKode($kode) {
        $result = prepared_query($this->conn, 'SELECT * FROM pesanan WHERE kode_pesanan = ?', 's', [$kode]);
        return mysqli_fetch_assoc($result);
    }

    public function getDetailPesanan($pesananId) {
        $result = prepared_query(
            $this->conn,
            'SELECT detail_pesanan.*, produk.nama_produk
             FROM detail_pesanan
             LEFT JOIN produk ON produk.id = detail_pesanan.produk_id
             WHERE detail_pesanan.pesanan_id = ?
             ORDER BY detail_pesanan.id ASC',
            'i',
            [(int) $pesananId]
        );
        $data = [];
        if($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}
