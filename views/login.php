<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';
if (isLoggedIn()) {
    header('Location: ' . BASE_URL . 'views/dashboard.php');
    exit();
}
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body class="login-page">
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1>🎓 SPK Beasiswa</h1>
            <p>Sistem Pendukung Keputusan Penerimaan Beasiswa</p>
        </div>
        <?php if ($flash): ?>
            <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
        <?php endif; ?>
        <form action="<?= BASE_URL ?>controllers/AuthController.php?action=login" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>
        <div style="text-align: center; margin-top: 15px;">
            <a href="<?= BASE_URL ?>views/lupa_password.php" style="color: #1a237e; text-decoration: none; font-size: 14px;">Lupa Password?</a>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
