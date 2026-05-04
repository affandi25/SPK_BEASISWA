<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../models/Setting.php';

requireAdmin();

$action = $_GET['action'] ?? '';
$settingModel = new Setting($pdo);

if ($action === 'update_kuota' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $kuota_prestasi    = max(0, (int)($_POST['kuota_prestasi'] ?? 0));
    $kuota_kurang_mampu = max(0, (int)($_POST['kuota_kurang_mampu'] ?? 0));

    $settingModel->updateKuota('prestasi', $kuota_prestasi);
    $settingModel->updateKuota('kurang_mampu', $kuota_kurang_mampu);

    setFlash('success', 'Pengaturan kuota berhasil disimpan.');
    header('Location: ' . BASE_URL . 'views/setting/kuota.php');
    exit();
}

if ($action === 'update_bobot' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis = $_POST['jenis_beasiswa'] ?? '';
    if (in_array($jenis, ['prestasi', 'kurang_mampu'])) {
        $raport      = (float)($_POST['bobot_raport'] ?? 0);
        $penghasilan = (float)($_POST['bobot_penghasilan'] ?? 0);
        $tanggungan  = (float)($_POST['bobot_tanggungan'] ?? 0);
        $settingModel->updateBobot($jenis, $raport, $penghasilan, $tanggungan);
        setFlash('success', 'Bobot kriteria berhasil diperbarui.');
    }
    header('Location: ' . BASE_URL . 'views/setting/kuota.php');
    exit();
}
