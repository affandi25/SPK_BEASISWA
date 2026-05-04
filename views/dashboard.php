<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/../models/Setting.php';

requireLogin();

$siswaModel = new Siswa($pdo);
$settingModel = new Setting($pdo);

$totalPrestasi    = $siswaModel->countByJenis('prestasi');
$totalKurangMampu = $siswaModel->countByJenis('kurang_mampu');
$diterimaPrestasi    = $siswaModel->countDiterima('prestasi');
$diterimaKurangMampu = $siswaModel->countDiterima('kurang_mampu');
$kuotaPrestasi    = $settingModel->getKuota('prestasi');
$kuotaKurangMampu = $settingModel->getKuota('kurang_mampu');

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/partials/navbar.php'; ?>
<div class="container">
    <div class="page-header">
        <h2>Dashboard</h2>
        <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (<?= $_SESSION['role'] ?>)</p>
    </div>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>
    <div class="stats-grid">
        <div class="stat-card stat-blue">
            <div class="stat-number"><?= $totalPrestasi + $totalKurangMampu ?></div>
            <div class="stat-label">Total Siswa</div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-number"><?= $totalPrestasi ?></div>
            <div class="stat-label">Beasiswa Prestasi</div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-number"><?= $totalKurangMampu ?></div>
            <div class="stat-label">Beasiswa Kurang Mampu</div>
        </div>
        <div class="stat-card stat-purple">
            <div class="stat-number"><?= $diterimaPrestasi + $diterimaKurangMampu ?></div>
            <div class="stat-label">Total Diterima</div>
        </div>
    </div>
    <div class="card-grid">
        <div class="card">
            <h3>Beasiswa Prestasi</h3>
            <table class="table-simple">
                <tr><td>Pendaftar</td><td><strong><?= $totalPrestasi ?></strong></td></tr>
                <tr><td>Kuota</td><td><strong><?= $kuotaPrestasi['jumlah_kuota'] ?? 0 ?></strong></td></tr>
                <tr><td>Diterima</td><td><strong class="text-green"><?= $diterimaPrestasi ?></strong></td></tr>
            </table>
        </div>
        <div class="card">
            <h3>Beasiswa Kurang Mampu</h3>
            <table class="table-simple">
                <tr><td>Pendaftar</td><td><strong><?= $totalKurangMampu ?></strong></td></tr>
                <tr><td>Kuota</td><td><strong><?= $kuotaKurangMampu['jumlah_kuota'] ?? 0 ?></strong></td></tr>
                <tr><td>Diterima</td><td><strong class="text-green"><?= $diterimaKurangMampu ?></strong></td></tr>
            </table>
        </div>
    </div>
    <div class="quick-actions">
        <a href="<?= BASE_URL ?>views/siswa/create.php" class="btn btn-primary">+ Tambah Siswa</a>
        <a href="<?= BASE_URL ?>views/ranking/index.php" class="btn btn-secondary">Lihat Ranking</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="<?= BASE_URL ?>views/setting/kuota.php" class="btn btn-secondary">Pengaturan Kuota</a>
        <?php endif; ?>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
