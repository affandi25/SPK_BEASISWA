<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../models/Siswa.php';

requireLogin();

$siswaModel = new Siswa($pdo);
$filter = $_GET['jenis'] ?? '';
$siswaList = $siswaModel->getAll($filter ?: null);
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
    <div class="page-header">
        <h2>Data Siswa</h2>
        <a href="<?= BASE_URL ?>views/siswa/create.php" class="btn btn-primary">+ Tambah Siswa</a>
    </div>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>
    <div class="filter-bar">
        <a href="?jenis=" class="btn btn-sm <?= !$filter ? 'btn-active' : 'btn-outline' ?>">Semua</a>
        <a href="?jenis=prestasi" class="btn btn-sm <?= $filter === 'prestasi' ? 'btn-active' : 'btn-outline' ?>">Prestasi</a>
        <a href="?jenis=kurang_mampu" class="btn btn-sm <?= $filter === 'kurang_mampu' ? 'btn-active' : 'btn-outline' ?>">Kurang Mampu</a>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jenis Beasiswa</th>
                    <th>Nilai Raport</th>
                    <th>Penghasilan Ortu</th>
                    <th>Tanggungan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($siswaList)): ?>
                <tr><td colspan="10" class="text-center">Belum ada data siswa.</td></tr>
            <?php else: ?>
                <?php foreach ($siswaList as $i => $s): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= htmlspecialchars($s['nis']) ?></td>
                    <td><?= htmlspecialchars($s['nama']) ?></td>
                    <td><?= htmlspecialchars($s['kelas']) ?></td>
                    <td><span class="badge badge-<?= $s['jenis_beasiswa'] === 'prestasi' ? 'blue' : 'orange' ?>"><?= $s['jenis_beasiswa'] === 'prestasi' ? 'Prestasi' : 'Kurang Mampu' ?></span></td>
                    <td><?= $s['nilai_raport'] ?></td>
                    <td>Rp <?= number_format($s['penghasilan_ortu'], 0, ',', '.') ?></td>
                    <td><?= $s['tanggungan_ortu'] ?> orang</td>
                    <td><span class="badge badge-<?= $s['status_penerima'] === 'diterima' ? 'green' : ($s['status_penerima'] === 'ditolak' ? 'red' : 'gray') ?>"><?= ucfirst($s['status_penerima']) ?></span></td>
                    <td class="action-btns">
                        <a href="<?= BASE_URL ?>views/siswa/edit.php?id=<?= $s['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                        <form method="POST" action="<?= BASE_URL ?>controllers/SiswaController.php?action=delete" style="display:inline" onsubmit="return confirm('Hapus siswa ini?')">
                            <input type="hidden" name="id" value="<?= $s['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        <?php endif; ?>
                    </td>
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
