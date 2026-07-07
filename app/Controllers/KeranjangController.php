<?php
class KeranjangController extends Controller {
    public function index() {
        global $conn;
        $cart = get_cart_items($conn);
        $data = [
            'pageTitle' => 'Keranjang',
            'activeUserPage' => 'keranjang',
            'cart' => $cart
        ];
        $this->view('keranjang/index', $data);
    }

    public function tambah() {
        $produkId = (int) ($_POST['produk_id'] ?? 0);
        $jumlah = max(1, (int) ($_POST['jumlah'] ?? 1));

        $produkModel = $this->model('ProdukModel');
        $produk = $produkModel->getById($produkId);

        if (!$produk) {
            set_flash('danger', 'Produk tidak ditemukan.');
            header('Location: ' . BASE_URL . 'produk');
            exit;
        }

        if ((int) $produk['stok'] <= 0) {
            set_flash('danger', 'Stok produk sedang kosong.');
            header('Location: ' . BASE_URL . 'produk/detail?id=' . $produkId);
            exit;
        }

        $_SESSION['cart'] = $_SESSION['cart'] ?? [];
        $jumlahBaru = (int) ($_SESSION['cart'][$produkId] ?? 0) + $jumlah;
        $_SESSION['cart'][$produkId] = min($jumlahBaru, (int) $produk['stok']);

        set_flash('success', 'Produk berhasil ditambahkan ke keranjang.');
        header('Location: ' . BASE_URL . 'keranjang');
        exit;
    }

    public function update() {
        $produkId = (int) ($_POST['produk_id'] ?? 0);
        $jumlah = (int) ($_POST['jumlah'] ?? 0);

        if ($produkId <= 0 || !isset($_SESSION['cart'][$produkId])) {
            set_flash('danger', 'Item keranjang tidak ditemukan.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        if ($jumlah <= 0) {
            unset($_SESSION['cart'][$produkId]);
            set_flash('success', 'Produk dihapus dari keranjang.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        $produkModel = $this->model('ProdukModel');
        $produk = $produkModel->getById($produkId);

        if (!$produk || (int) $produk['stok'] <= 0) {
            unset($_SESSION['cart'][$produkId]);
            set_flash('danger', 'Produk tidak tersedia dan dihapus dari keranjang.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        $_SESSION['cart'][$produkId] = min($jumlah, (int) $produk['stok']);
        set_flash('success', 'Jumlah produk berhasil diperbarui.');
        header('Location: ' . BASE_URL . 'keranjang');
        exit;
    }

    public function hapus() {
        $id = (int) ($_GET['id'] ?? 0);
        if ($id > 0 && isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
            set_flash('success', 'Produk dihapus dari keranjang.');
        }
        header('Location: ' . BASE_URL . 'keranjang');
        exit;
    }
}
