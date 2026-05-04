<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../models/Siswa.php';
require_once __DIR__ . '/../../models/Setting.php';

requireLogin();

$siswaModel = new Siswa($pdo);
$settingModel = new Setting($pdo);

$filter = $_GET['jenis'] ?? 'prestasi';
if (!in_array($filter, ['prestasi', 'kurang_mampu'])) $filter = 'prestasi';

$siswaList = $siswaModel->getAll($filter);
$bobot = $settingModel->getBobot($filter);
$kuota = $settingModel->getKuota($filter);
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
    <div class="page-header">
        <h2>Hasil Ranking Beasiswa</h2>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <form method="POST" action="<?= BASE_URL ?>controllers/RankingController.php?action=hitung" style="display:inline">
            <button type="submit" class="btn btn-primary" onclick="return confirm('Hitung ulang ranking semua siswa?')">🔄 Hitung Ranking</button>
        </form>
        <?php endif; ?>
    </div>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>
    <div class="filter-bar">
        <a href="?jenis=prestasi" class="btn btn-sm <?= $filter === 'prestasi' ? 'btn-active' : 'btn-outline' ?>">Prestasi</a>
        <a href="?jenis=kurang_mampu" class="btn btn-sm <?= $filter === 'kurang_mampu' ? 'btn-active' : 'btn-outline' ?>">Kurang Mampu</a>
    </div>
    <?php if ($bobot): ?>
    <div class="info-box">
        <strong>Bobot Kriteria <?= $filter === 'prestasi' ? 'Prestasi' : 'Kurang Mampu' ?>:</strong>
        Nilai Raport: <strong><?= $bobot['bobot_raport'] ?></strong> |
        Penghasilan Ortu: <strong><?= $bobot['bobot_penghasilan'] ?></strong> |
        Tanggungan: <strong><?= $bobot['bobot_tanggungan'] ?></strong> |
        Kuota: <strong><?= $kuota['jumlah_kuota'] ?? 0 ?> orang</strong>
    </div>
    <?php endif; ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Ranking</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Nilai Raport</th>
                    <th>Penghasilan Ortu</th>
                    <th>Tanggungan</th>
                    <th>Skor SAW</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($siswaList)): ?>
                <tr><td colspan="9" class="text-center">Belum ada data. Tambah siswa dan klik "Hitung Ranking".</td></tr>
            <?php else: ?>
                <?php foreach ($siswaList as $s): ?>
                <tr class="<?= $s['status_penerima'] === 'diterima' ? 'row-diterima' : '' ?>">
                    <td class="text-center"><strong><?= $s['ranking'] ?: '-' ?></strong></td>
                    <td><?= htmlspecialchars($s['nis']) ?></td>
                    <td><?= htmlspecialchars($s['nama']) ?></td>
                    <td><?= htmlspecialchars($s['kelas']) ?></td>
                    <td><?= $s['nilai_raport'] ?></td>
                    <td>Rp <?= number_format($s['penghasilan_ortu'], 0, ',', '.') ?></td>
                    <td><?= $s['tanggungan_ortu'] ?></td>
                    <td><strong><?= $s['skor_akhir'] > 0 ? number_format($s['skor_akhir'], 4) : '-' ?></strong></td>
                    <td><span class="badge badge-<?= $s['status_penerima'] === 'diterima' ? 'green' : ($s['status_penerima'] === 'ditolak' ? 'red' : 'gray') ?>"><?= ucfirst($s['status_penerima']) ?></span></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
