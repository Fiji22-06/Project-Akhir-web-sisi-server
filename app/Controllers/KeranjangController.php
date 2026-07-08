<?php
class KeranjangController extends Controller {
    private function wantsJson() {
        $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
        $requestedWith = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';

        return str_contains($accept, 'application/json') || strtolower($requestedWith) === 'xmlhttprequest';
    }

    private function jsonResponse(array $payload, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit;
    }

    private function redirectBack($fallback = 'produk') {
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        $fallbackUrl = BASE_URL . $fallback;

        if ($referer === '') {
            header('Location: ' . $fallbackUrl);
            exit;
        }

        $refererParts = parse_url($referer);
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $refererHost = $refererParts['host'] ?? $host;
        $refererPath = $refererParts['path'] ?? '';

        if ($refererHost === $host && str_starts_with($refererPath, BASE_URL)) {
            $target = $refererPath;

            if (!empty($refererParts['query'])) {
                $target .= '?' . $refererParts['query'];
            }

            header('Location: ' . $target);
            exit;
        }

        header('Location: ' . $fallbackUrl);
        exit;
    }

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
        $this->redirectBack();
    }

    public function update() {
        global $conn;
        $produkId = (int) ($_POST['produk_id'] ?? 0);
        $jumlah = (int) ($_POST['jumlah'] ?? 0);
        $wantsJson = $this->wantsJson();

        if ($produkId <= 0 || !isset($_SESSION['cart'][$produkId])) {
            if ($wantsJson) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Item keranjang tidak ditemukan.',
                ], 404);
            }

            set_flash('danger', 'Item keranjang tidak ditemukan.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        if ($jumlah <= 0) {
            unset($_SESSION['cart'][$produkId]);
            if ($wantsJson) {
                $cart = get_cart_items($conn);
                $this->jsonResponse([
                    'success' => true,
                    'removed' => true,
                    'total' => $cart['total'],
                    'totalFormatted' => rupiah($cart['total']),
                    'cartCount' => get_cart_count(),
                    'message' => 'Produk dihapus dari keranjang.',
                ]);
            }

            set_flash('success', 'Produk dihapus dari keranjang.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        $produkModel = $this->model('ProdukModel');
        $produk = $produkModel->getById($produkId);

        if (!$produk || (int) $produk['stok'] <= 0) {
            unset($_SESSION['cart'][$produkId]);
            if ($wantsJson) {
                $cart = get_cart_items($conn);
                $this->jsonResponse([
                    'success' => false,
                    'removed' => true,
                    'total' => $cart['total'],
                    'totalFormatted' => rupiah($cart['total']),
                    'cartCount' => get_cart_count(),
                    'message' => 'Produk tidak tersedia dan dihapus dari keranjang.',
                ], 410);
            }

            set_flash('danger', 'Produk tidak tersedia dan dihapus dari keranjang.');
            header('Location: ' . BASE_URL . 'keranjang');
            exit;
        }

        $jumlah = min($jumlah, (int) $produk['stok']);
        $_SESSION['cart'][$produkId] = $jumlah;

        if ($wantsJson) {
            $cart = get_cart_items($conn);
            $itemSubtotal = (float) $produk['harga'] * $jumlah;

            $this->jsonResponse([
                'success' => true,
                'jumlah' => $jumlah,
                'subtotal' => $itemSubtotal,
                'subtotalFormatted' => rupiah($itemSubtotal),
                'total' => $cart['total'],
                'totalFormatted' => rupiah($cart['total']),
                'cartCount' => get_cart_count(),
                'message' => 'Jumlah produk berhasil diperbarui.',
            ]);
        }

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
