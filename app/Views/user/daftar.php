<?php
$error = $data['error'] ?? null;
$old = $data['old'] ?? [];
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Pelanggan | TOKO BROD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= BASE_URL; ?>assets/css/style.css" rel="stylesheet">
</head>
<body class="login-page">
    <main class="login-shell">
        <section class="login-panel">
            <div class="brand-mark">
                <i class="bi bi-person-plus"></i>
            </div>
            <h1>Daftar Pelanggan</h1>
            <p class="login-subtitle">Buat akun pelanggan untuk masuk dari sisi user TOKO BROD.</p>

            <?php if ($error): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= e($error); ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= BASE_URL; ?>user/daftar" method="post" class="login-form">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= e($old['nama'] ?? ''); ?>" placeholder="Masukkan nama lengkap" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-at"></i></span>
                        <input type="text" name="username" id="username" class="form-control" value="<?= e($old['username'] ?? ''); ?>" placeholder="Contoh: pelanggan01" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="password_confirm" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-check"></i></span>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control" placeholder="Ulangi password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-person-check me-1"></i> Buat Akun
                </button>
                <a href="<?= BASE_URL; ?>user/login" class="btn btn-outline-primary w-100 mt-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Sudah Punya Akun
                </a>
                <a href="<?= BASE_URL; ?>" class="btn btn-outline-secondary w-100 mt-2">
                    <i class="bi bi-house-door me-1"></i> Kembali ke Home
                </a>
            </form>
        </section>
    </main>
</body>
</html>
