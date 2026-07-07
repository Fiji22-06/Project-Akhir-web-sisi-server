<?php
class AdminPesananController extends Controller {
    public function index() {
        require_login();
        global $conn;
        $result = mysqli_query($conn, 'SELECT id, kode_pesanan, nama_pelanggan, no_hp, total_harga, status_pesanan, created_at FROM pesanan ORDER BY id DESC');
        $orders = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }
        }
        $this->view('adminpesanan/index', [
            'pageTitle' => 'Data Pesanan',
            'activePage' => 'pesanan',
            'orders' => $orders
        ]);
    }

    public function detail() {
        require_login();
        global $conn;
        
        $id = (int) ($_GET['id'] ?? 0);
        $pesanan = mysqli_fetch_assoc(prepared_query($conn, 'SELECT * FROM pesanan WHERE id = ?', 'i', [$id]));

        if (!$pesanan) {
            set_flash('danger', 'Pesanan tidak ditemukan.');
            header('Location: ' . BASE_URL . 'adminpesanan');
            exit;
        }

        $result = prepared_query(
            $conn,
            'SELECT detail_pesanan.*, produk.nama_produk
             FROM detail_pesanan
             LEFT JOIN produk ON produk.id = detail_pesanan.produk_id
             WHERE detail_pesanan.pesanan_id = ?
             ORDER BY detail_pesanan.id ASC',
            'i',
            [$id]
        );
        $detail = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $detail[] = $row;
            }
        }

        $this->view('adminpesanan/detail', [
            'pageTitle' => 'Detail Pesanan',
            'activePage' => 'pesanan',
            'pesanan' => $pesanan,
            'detail' => $detail
        ]);
    }

    public function edit() {
        require_login();
        global $conn;

        $id = (int) ($_GET['id'] ?? 0);
        $pesanan = mysqli_fetch_assoc(prepared_query($conn, 'SELECT * FROM pesanan WHERE id = ?', 'i', [$id]));

        if (!$pesanan) {
            set_flash('danger', 'Pesanan tidak ditemukan.');
            header('Location: ' . BASE_URL . 'adminpesanan');
            exit;
        }

        $statusList = ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status_pesanan'] ?? '';

            if (!in_array($status, $statusList, true)) {
                set_flash('danger', 'Status pesanan tidak valid.');
            } else {
                $update = mysqli_prepare($conn, 'UPDATE pesanan SET status_pesanan = ? WHERE id = ?');
                mysqli_stmt_bind_param($update, 'si', $status, $id);

                if (mysqli_stmt_execute($update)) {
                    set_flash('success', 'Status pesanan berhasil diperbarui.');
                    header('Location: ' . BASE_URL . 'adminpesanan');
                    exit;
                }

                set_flash('danger', 'Status pesanan gagal diperbarui.');
            }
        }

        $this->view('adminpesanan/edit', [
            'pageTitle' => 'Edit Status Pesanan',
            'activePage' => 'pesanan',
            'pesanan' => $pesanan,
            'statusList' => $statusList
        ]);
    }

    public function hapus() {
        require_login();
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id'] ?? 0);
            
            $stmt = mysqli_prepare($conn, 'DELETE FROM pesanan WHERE id = ?');
            mysqli_stmt_bind_param($stmt, 'i', $id);
            if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
                set_flash('success', 'Pesanan berhasil dihapus.');
            } else {
                set_flash('danger', 'Gagal menghapus pesanan atau pesanan tidak ditemukan.');
            }
        }

        header('Location: ' . BASE_URL . 'adminpesanan');
        exit;
    }
}
