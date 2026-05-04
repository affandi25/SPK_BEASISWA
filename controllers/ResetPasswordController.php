<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';

$action = $_GET['action'] ?? '';

// Step 1: Cek Username
if ($action === 'check_username' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');

    if (empty($username)) {
        setFlash('error', 'Username wajib diisi.');
        header('Location: ' . BASE_URL . 'views/lupa_password.php');
        exit();
    }

    // Cek apakah username ada di database
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        setFlash('error', 'Username tidak ditemukan.');
        header('Location: ' . BASE_URL . 'views/lupa_password.php');
        exit();
    }

    // Username ditemukan, lanjut ke step 2
    header('Location: ' . BASE_URL . 'views/lupa_password.php?step=reset&username=' . urlencode($username));
    exit();
}

// Step 2: Reset Password
if ($action === 'reset_password' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password_baru = $_POST['password_baru'] ?? '';
    $password_konfirmasi = $_POST['password_konfirmasi'] ?? '';

    // Validasi
    if (empty($username) || empty($password_baru) || empty($password_konfirmasi)) {
        setFlash('error', 'Semua field wajib diisi.');
        header('Location: ' . BASE_URL . 'views/lupa_password.php?step=reset&username=' . urlencode($username));
        exit();
    }

    if ($password_baru !== $password_konfirmasi) {
        setFlash('error', 'Password baru dan konfirmasi tidak cocok.');
        header('Location: ' . BASE_URL . 'views/lupa_password.php?step=reset&username=' . urlencode($username));
        exit();
    }

    if (strlen($password_baru) < 6) {
        setFlash('error', 'Password minimal 6 karakter.');
        header('Location: ' . BASE_URL . 'views/lupa_password.php?step=reset&username=' . urlencode($username));
        exit();
    }

    // Update password
    $hash_baru = password_hash($password_baru, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->execute([$hash_baru, $username]);

    setFlash('success', 'Password berhasil direset! Silakan login dengan password baru.');
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

// Kalau akses langsung tanpa action
header('Location: ' . BASE_URL . 'views/lupa_password.php');
exit();
