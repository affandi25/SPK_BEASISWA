<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../models/User.php';

$action = $_GET['action'] ?? '';

if ($action === 'login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        setFlash('error', 'Username dan password wajib diisi.');
        header('Location: ' . BASE_URL . 'views/login.php');
        exit();
    }

    $userModel = new User($pdo);
    $user = $userModel->findByUsername($username);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header('Location: ' . BASE_URL . 'views/dashboard.php');
    } else {
        setFlash('error', 'Username atau password salah.');
        header('Location: ' . BASE_URL . 'views/login.php');
    }
    exit();
}

if ($action === 'logout') {
    session_destroy();
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}
