<?php
class PesananController extends Controller {
    public function cek() {
        $keyword = trim($_GET['keyword'] ?? '');
        $pesananResult = null;
        $searched = $keyword !== '';

        if ($searched) {
            $pesananModel = $this->model('PesananModel');
            $pesananResult = $pesananModel->cariPesanan($keyword);
        }

        $data = [
            'pageTitle' => 'Cek Pesanan',
            'activeUserPage' => 'cek',
            'keyword' => $keyword,
            'searched' => $searched,
            'pesananResult' => $pesananResult
        ];

        $this->view('pesanan/cek', $data);
    }

    public function detail() {
        $kode = trim($_GET['kode'] ?? '');
        $pesananModel = $this->model('PesananModel');
        $pesanan = $pesananModel->getByKode($kode);

        if (!$pesanan) {
            set_flash('danger', 'Pesanan tidak ditemukan.');
            header('Location: ' . BASE_URL . 'pesanan/cek');
            exit;
        }

        $detail = $pesananModel->getDetailPesanan($pesanan['id']);

        $data = [
            'pageTitle' => 'Detail Pesanan',
            'activeUserPage' => 'cek',
            'pesanan' => $pesanan,
            'detail' => $detail
        ];

        $this->view('pesanan/detail', $data);
    }

    public function bukti() {
        $kode = trim($_GET['kode'] ?? '');
        $pesananModel = $this->model('PesananModel');
        $pesanan = $pesananModel->getByKode($kode);

        if (!$pesanan) {
            set_flash('danger', 'Pesanan tidak ditemukan.');
            header('Location: ' . BASE_URL . 'pesanan/cek');
            exit;
        }

        $detail = $pesananModel->getDetailPesanan($pesanan['id']);

        $data = [
            'pageTitle' => 'Bukti Pesanan',
            'activeUserPage' => 'cek',
            'pesanan' => $pesanan,
            'detail' => $detail
        ];

        $this->view('pesanan/bukti', $data);
    }
}
