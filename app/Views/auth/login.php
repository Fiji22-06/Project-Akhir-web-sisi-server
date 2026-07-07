<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Admin BROD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
    <main class="login-shell">
        <section class="login-panel">
            <div class="brand-mark">
                <i class="bi bi-box-seam"></i>
            </div>
            <h1>Sistem Admin TOKO BROD</h1>
            <p class="login-subtitle">Masuk untuk mengelola pengguna, kategori, dan produk toko.</p>

            <?php if ($data['error']): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= e($data['error']); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL; ?>auth/proses" method="post" class="login-form">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Login
                </button>
                <a href="<?= BASE_URL; ?>" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Home
                </a>
            </form>
        </section>
    </main>
</body>
</html>
