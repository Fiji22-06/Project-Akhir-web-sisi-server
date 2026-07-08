    </main>
    <footer class="user-footer">
        <div class="container">
            <div class="footer-main">
                <div class="footer-brand-block">
                    <div class="footer-brand">
                        <span class="user-brand-icon"><i class="bi bi-shop"></i></span>
                        <strong>TOKO BROD</strong>
                    </div>
                    <p>Belanja produk kebutuhan harian dengan proses mudah, cepat, dan status pesanan yang bisa dicek kapan saja.</p>
                </div>
                <div class="footer-column">
                    <h4>Menu Toko</h4>
                    <a href="<?= BASE_URL; ?>produk">Produk</a>
                    <a href="<?= BASE_URL; ?>keranjang">Keranjang</a>
                    <a href="<?= BASE_URL; ?>pesanan/cek">Cek Pesanan</a>
                </div>
                <div class="footer-column">
                    <h4>Layanan</h4>
                    <a href="<?= BASE_URL; ?>user/login"><i class="bi bi-person-circle"></i> Login User</a>
                    <span><i class="bi bi-bag-check"></i> Checkout tanpa akun</span>
                    <span><i class="bi bi-receipt"></i> Bukti pesanan otomatis</span>
                    <a href="<?= BASE_URL; ?>auth/login"><i class="bi bi-shield-lock"></i> Login Admin</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; <?= date('Y'); ?> TOKO BROD. Sistem Manajemen Data Produk Toko.</span>
                <span>Project UAS Web Sisi Server</span>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL; ?>assets/js/script.js"></script>
</body>
</html>
