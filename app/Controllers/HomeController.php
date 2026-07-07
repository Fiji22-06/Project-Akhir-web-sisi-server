<?php
class HomeController extends Controller {
    public function index() {
        $kategoriModel = $this->model('KategoriModel');
        $produkModel = $this->model('ProdukModel');

        $data = [
            'pageTitle' => 'Beranda',
            'activeUserPage' => 'home',
            'kategori' => $kategoriModel->getAllWithCount(),
            'produkTerbaru' => $produkModel->getLatest(6)
        ];

        $this->view('home/index', $data);
    }
}
