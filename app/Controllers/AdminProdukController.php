<?php
class AdminProdukController extends Controller {
    public function index() {
        require_login();
        global $conn;
        $result = mysqli_query($conn, 
            'SELECT produk.id, produk.nama_produk, produk.harga, produk.stok, kategori.nama_kategori
             FROM produk
             LEFT JOIN kategori ON kategori.id = produk.kategori_id
             ORDER BY produk.id DESC'
        );
        $products = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }
        $this->view('adminproduk/index', [
            'pageTitle' => 'Data Produk',
            'activePage' => 'produk',
            'products' => $products
        ]);
    }

    public function tambah() {
        require_login();
        global $conn;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $namaProduk = trim($_POST['nama_produk'] ?? '');
            $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
            $harga = (float) ($_POST['harga'] ?? 0);
            $stok = (int) ($_POST['stok'] ?? 0);
            $deskripsi = trim($_POST['deskripsi'] ?? '');

            if ($namaProduk === '' || $kategoriId <= 0 || $harga < 0 || $stok < 0) {
                set_flash('danger', 'Nama produk, kategori, harga, dan stok wajib diisi dengan benar.');
            } else {
                $stmt = mysqli_prepare($conn, 'INSERT INTO produk (nama_produk, kategori_id, harga, stok, deskripsi) VALUES (?, ?, ?, ?, ?)');
                mysqli_stmt_bind_param($stmt, 'sidis', $namaProduk, $kategoriId, $harga, $stok, $deskripsi);

                if (mysqli_stmt_execute($stmt)) {
                    set_flash('success', 'Produk berhasil ditambahkan.');
                    header('Location: ' . BASE_URL . 'adminproduk');
                    exit;
                }
                set_flash('danger', 'Produk gagal ditambahkan.');
            }
        }

        $kategoriResult = mysqli_query($conn, 'SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC');
        $categories = [];
        if ($kategoriResult) {
            while ($c = mysqli_fetch_assoc($kategoriResult)) {
                $categories[] = $c;
            }
        }

        $this->view('adminproduk/tambah', [
            'pageTitle' => 'Tambah Produk',
            'activePage' => 'produk',
            'categories' => $categories
        ]);
    }

    public function edit() {
        require_login();
        global $conn;

        $id = (int) ($_GET['id'] ?? 0);
        $produk = mysqli_fetch_assoc(prepared_query($conn, 'SELECT * FROM produk WHERE id = ?', 'i', [$id]));

        if (!$produk) {
            set_flash('danger', 'Produk tidak ditemukan.');
            header('Location: ' . BASE_URL . 'adminproduk');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $namaProduk = trim($_POST['nama_produk'] ?? '');
            $kategoriId = (int) ($_POST['kategori_id'] ?? 0);
            $harga = (float) ($_POST['harga'] ?? 0);
            $stok = (int) ($_POST['stok'] ?? 0);
            $deskripsi = trim($_POST['deskripsi'] ?? '');

            if ($namaProduk === '' || $kategoriId <= 0 || $harga < 0 || $stok < 0) {
                set_flash('danger', 'Nama produk, kategori, harga, dan stok wajib diisi dengan benar.');
            } else {
                $stmt = mysqli_prepare($conn, 'UPDATE produk SET nama_produk = ?, kategori_id = ?, harga = ?, stok = ?, deskripsi = ? WHERE id = ?');
                mysqli_stmt_bind_param($stmt, 'sidisi', $namaProduk, $kategoriId, $harga, $stok, $deskripsi, $id);

                if (mysqli_stmt_execute($stmt)) {
                    set_flash('success', 'Produk berhasil diperbarui.');
                    header('Location: ' . BASE_URL . 'adminproduk');
                    exit;
                }
                set_flash('danger', 'Produk gagal diperbarui.');
            }
        }

        $kategoriResult = mysqli_query($conn, 'SELECT id, nama_kategori FROM kategori ORDER BY nama_kategori ASC');
        $categories = [];
        if ($kategoriResult) {
            while ($c = mysqli_fetch_assoc($kategoriResult)) {
                $categories[] = $c;
            }
        }

        $this->view('adminproduk/edit', [
            'pageTitle' => 'Edit Produk',
            'activePage' => 'produk',
            'produk' => $produk,
            'categories' => $categories
        ]);
    }

    public function hapus() {
        require_login();
        global $conn;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int) ($_POST['id'] ?? 0);
            
            $checkPesanan = prepared_query($conn, 'SELECT id FROM detail_pesanan WHERE produk_id = ? LIMIT 1', 'i', [$id]);
            if (mysqli_num_rows($checkPesanan) > 0) {
                set_flash('danger', 'Produk tidak dapat dihapus karena sudah ada dalam pesanan pelanggan.');
            } else {
                $stmt = mysqli_prepare($conn, 'DELETE FROM produk WHERE id = ?');
                mysqli_stmt_bind_param($stmt, 'i', $id);
                if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
                    set_flash('success', 'Produk berhasil dihapus.');
                } else {
                    set_flash('danger', 'Gagal menghapus produk atau produk tidak ditemukan.');
                }
            }
        }

        header('Location: ' . BASE_URL . 'adminproduk');
        exit;
    }
}
