<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';

if (isLoggedIn()) {
    header('Location: ' . BASE_URL . 'views/dashboard.php');
    exit();
}

$flash = getFlash();
$step = $_GET['step'] ?? 'username';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="login-page">
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>🔐 Lupa Password</h1>
            <p>Reset password tanpa perlu password lama</p>
        </div>
        
        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
        <?php endif; ?>

        <?php if ($step === 'username'): ?>
        <!-- Step 1: Input Username -->
        <form action="<?= BASE_URL ?>controllers/ResetPasswordController.php?action=check_username" method="POST">
            <div class="form-group">
                <label for="username">Masukkan Username Anda</label>
                <input type="text" id="username" name="username" class="form-control" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Lanjutkan</button>
            <a href="<?= BASE_URL ?>views/login.php" class="btn btn-secondary btn-block" style="margin-top: 10px;">Kembali ke Login</a>
        </form>
        
        <?php elseif ($step === 'reset'): ?>
        <!-- Step 2: Input Password Baru -->
        <p style="margin-bottom: 20px; color: #2e7d32;">✅ Username ditemukan! Silakan buat password baru.</p>
        <form action="<?= BASE_URL ?>controllers/ResetPasswordController.php?action=reset_password" method="POST">
            <input type="hidden" name="username" value="<?= htmlspecialchars($_GET['username'] ?? '') ?>">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($_GET['username'] ?? '') ?>" disabled>
            </div>
            <div class="form-group">
                <label for="password_baru">Password Baru</label>
                <input type="password" id="password_baru" name="password_baru" class="form-control" minlength="6" required>
                <small style="color: #666;">Minimal 6 karakter</small>
            </div>
            <div class="form-group">
                <label for="password_konfirmasi">Konfirmasi Password Baru</label>
                <input type="password" id="password_konfirmasi" name="password_konfirmasi" class="form-control" minlength="6" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
            <a href="<?= BASE_URL ?>views/login.php" class="btn btn-secondary btn-block" style="margin-top: 10px;">Batal</a>
        </form>
        <?php endif; ?>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
<script>
const form = document.querySelector('form');
if (form && form.querySelector('[name="password_baru"]')) {
    form.addEventListener('submit', function(e) {
        const passwordBaru = document.querySelector('[name="password_baru"]').value;
        const passwordKonfirmasi = document.querySelector('[name="password_konfirmasi"]').value;
        
        if (passwordBaru !== passwordKonfirmasi) {
            alert('Password baru dan konfirmasi tidak cocok!');
            e.preventDefault();
            return false;
        }
    });
}
</script>
</body>
</html>
