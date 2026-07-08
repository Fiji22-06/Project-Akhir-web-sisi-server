<?php
class ProdukController extends Controller {
    public function index() {
        $produkModel = $this->model('ProdukModel');
        $kategoriModel = $this->model('KategoriModel');

        $keyword = trim($_GET['q'] ?? '');
        $kategoriId = (int) ($_GET['kategori_id'] ?? 0);

        $data = [
            'pageTitle' => 'Produk',
            'activeUserPage' => 'produk',
            'keyword' => $keyword,
            'kategoriId' => $kategoriId,
            'kategori' => $kategoriModel->getAll(),
            'produk' => $produkModel->getAllFiltered($keyword, $kategoriId)
        ];

        $this->view('produk/index', $data);
    }

    public function detail() {
        $id = (int) ($_GET['id'] ?? 0);
        $produkModel = $this->model('ProdukModel');
        $produk = $produkModel->getAvailableById($id);

        if (!$produk) {
            set_flash('danger', 'Produk tidak ditemukan atau stok sudah habis.');
            header('Location: ' . BASE_URL . 'produk');
            exit;
        }

        $data = [
            'pageTitle' => 'Detail Produk',
            'activeUserPage' => 'produk',
            'produk' => $produk
        ];

        $this->view('produk/detail', $data);
    }
}
