<?php
class KategoriController extends Controller {
    public function index() {
        require_login();
        global $conn;
        $result = mysqli_query($conn, 'SELECT id, nama_kategori, deskripsi FROM kategori ORDER BY nama_kategori ASC');
        $categories = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $categories[] = $row;
            }
        }
        $this->view('kategori/index', [
            'pageTitle' => 'Data Kategori',
            'activePage' => 'kategori',
            'categories' => $categories
        ]);
    }

    public function tambah() {
        require_login();
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama_kategori'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');

            if ($nama === '') {
                set_flash('danger', 'Nama kategori wajib diisi.');
            } else {
                $check = mysqli_prepare($conn, 'SELECT id FROM kategori WHERE nama_kategori = ? LIMIT 1');
                mysqli_stmt_bind_param($check, 's', $nama);
                mysqli_stmt_execute($check);
                $exists = mysqli_stmt_get_result($check);

                if (mysqli_num_rows($exists) > 0) {
                    set_flash('danger', 'Kategori dengan nama tersebut sudah ada.');
                } else {
                    $stmt = mysqli_prepare($conn, 'INSERT INTO kategori (nama_kategori, deskripsi) VALUES (?, ?)');
                    mysqli_stmt_bind_param($stmt, 'ss', $nama, $deskripsi);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        set_flash('success', 'Kategori berhasil ditambahkan.');
                        header('Location: ' . BASE_URL . 'kategori');
                        exit;
                    }
                    set_flash('danger', 'Gagal menambahkan kategori.');
                }
            }
        }

        $this->view('kategori/tambah', [
            'pageTitle' => 'Tambah Kategori',
            'activePage' => 'kategori'
        ]);
    }

    public function edit() {
        require_login();
        global $conn;

        $id = (int) ($_GET['id'] ?? 0);
        $kategori = mysqli_fetch_assoc(prepared_query($conn, 'SELECT id, nama_kategori, deskripsi FROM kategori WHERE id = ?', 'i', [$id]));

        if (!$kategori) {
            set_flash('danger', 'Kategori tidak ditemukan.');
            header('Location: ' . BASE_URL . 'kategori');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama_kategori'] ?? '');
            $deskripsi = trim($_POST['deskripsi'] ?? '');

            if ($nama === '') {
                set_flash('danger', 'Nama kategori wajib diisi.');
            } else {
                $check = mysqli_prepare($conn, 'SELECT id FROM kategori WHERE nama_kategori = ? AND id != ? LIMIT 1');
                mysqli_stmt_bind_param($check, 'si', $nama, $id);
                mysqli_stmt_execute($check);
                $exists = mysqli_stmt_get_result($check);

                if (mysqli_num_rows($exists) > 0) {
                    set_flash('danger', 'Nama kategori sudah digunakan.');
                } else {
                    $stmt = mysqli_prepare($conn, 'UPDATE kategori SET nama_kategori = ?, deskripsi = ? WHERE id = ?');
                    mysqli_stmt_bind_param($stmt, 'ssi', $nama, $deskripsi, $id);
                    
                    if (mysqli_stmt_execute($stmt)) {
                        set_flash('success', 'Kategori berhasil diperbarui.');
                        header('Location: ' . BASE_URL . 'kategori');
                        exit;
                    }
                    set_flash('danger', 'Gagal memperbarui kategori.');
                }
            }
        }

        $this->view('kategori/edit', [
            'pageTitle' => 'Edit Kategori',
            'activePage' => 'kategori',
            'kategori' => $kategori
        ]);
    }

    public function hapus() {
        require_login();
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id'] ?? 0);
            
            $checkProduk = prepared_query($conn, 'SELECT id FROM produk WHERE kategori_id = ? LIMIT 1', 'i', [$id]);
            if (mysqli_num_rows($checkProduk) > 0) {
                set_flash('danger', 'Kategori tidak dapat dihapus karena masih digunakan oleh produk.');
            } else {
                $stmt = mysqli_prepare($conn, 'DELETE FROM kategori WHERE id = ?');
                mysqli_stmt_bind_param($stmt, 'i', $id);
                if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
                    set_flash('success', 'Kategori berhasil dihapus.');
                } else {
                    set_flash('danger', 'Gagal menghapus kategori atau kategori tidak ditemukan.');
                }
            }
        }

        header('Location: ' . BASE_URL . 'kategori');
        exit;
    }
}
