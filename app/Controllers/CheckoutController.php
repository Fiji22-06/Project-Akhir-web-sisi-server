<?php
class CheckoutController extends Controller {
    public function index() {
        global $conn;
        $cart = get_cart_items($conn);
        if (!$cart['items']) {
            set_flash('danger', 'Keranjang masih kosong.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }
        $data = [
            'pageTitle' => 'Checkout',
            'activeUserPage' => 'keranjang',
            'cart' => $cart
        ];
        $this->view('checkout/index', $data);
    }

    public function proses() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'checkout');
            exit;
        }

        global $conn;
        $cart = get_cart_items($conn);
        $nama = trim($_POST['nama_pelanggan'] ?? '');
        $noHp = trim($_POST['no_hp'] ?? '');
        $alamat = trim($_POST['alamat'] ?? '');
        $metode = $_POST['metode_pembayaran'] ?? '';
        $metodeList = ['COD', 'Transfer Bank', 'E-Wallet'];

        $_SESSION['checkout_old'] = [
            'nama_pelanggan' => $nama,
            'no_hp' => $noHp,
            'alamat' => $alamat,
            'metode_pembayaran' => $metode,
        ];

        if (!$cart['items']) {
            set_flash('danger', 'Keranjang tidak boleh kosong.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        if ($nama === '' || $noHp === '' || $alamat === '' || $metode === '') {
            set_flash('danger', 'Semua field checkout wajib diisi.');
            header('Location: ' . BASE_URL . 'checkout');
            exit;
        }

        if (!ctype_digit($noHp)) {
            set_flash('danger', 'Nomor HP hanya boleh berisi angka.');
            header('Location: ' . BASE_URL . 'checkout');
            exit;
        }

        if (!in_array($metode, $metodeList, true)) {
            set_flash('danger', 'Metode pembayaran tidak valid.');
            header('Location: ' . BASE_URL . 'checkout');
            exit;
        }

        $pesananModel = $this->model('PesananModel');
        $kodePesanan = $pesananModel->createPesanan($nama, $noHp, $alamat, $metode, $cart);

        if ($kodePesanan) {
            unset($_SESSION['cart'], $_SESSION['checkout_old']);
            header('Location: ' . BASE_URL . 'pesanan/bukti?kode=' . urlencode($kodePesanan));
            exit;
        } else {
            set_flash('danger', 'Checkout gagal diproses. Silakan coba lagi.');
            header('Location: ' . BASE_URL . 'checkout');
            exit;
        }
    }
}
