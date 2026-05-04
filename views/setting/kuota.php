<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../models/Setting.php';

requireAdmin();

$settingModel = new Setting($pdo);
$kuotaPrestasi    = $settingModel->getKuota('prestasi');
$kuotaKurangMampu = $settingModel->getKuota('kurang_mampu');
$bobotPrestasi    = $settingModel->getBobot('prestasi');
$bobotKurangMampu = $settingModel->getBobot('kurang_mampu');
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
    <div class="page-header">
        <h2>Pengaturan Kuota & Bobot</h2>
    </div>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>

    <!-- Kuota -->
    <div class="form-card">
        <h3>Kuota Penerima Beasiswa</h3>
        <form action="<?= BASE_URL ?>controllers/SettingController.php?action=update_kuota" method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Kuota Beasiswa Prestasi</label>
                    <input type="number" name="kuota_prestasi" class="form-control" value="<?= $kuotaPrestasi['jumlah_kuota'] ?? 0 ?>" min="0" required>
                </div>
                <div class="form-group">
                    <label>Kuota Beasiswa Kurang Mampu</label>
                    <input type="number" name="kuota_kurang_mampu" class="form-control" value="<?= $kuotaKurangMampu['jumlah_kuota'] ?? 0 ?>" min="0" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Kuota</button>
        </form>
    </div>

    <!-- Bobot Prestasi -->
    <div class="form-card">
        <h3>Bobot Kriteria - Beasiswa Prestasi</h3>
        <form action="<?= BASE_URL ?>controllers/SettingController.php?action=update_bobot" method="POST">
            <input type="hidden" name="jenis_beasiswa" value="prestasi">
            <div class="form-row">
                <div class="form-group">
                    <label>Bobot Nilai Raport</label>
                    <input type="number" name="bobot_raport" class="form-control" value="<?= $bobotPrestasi['bobot_raport'] ?? 0.80 ?>" min="0" max="1" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Bobot Penghasilan Ortu</label>
                    <input type="number" name="bobot_penghasilan" class="form-control" value="<?= $bobotPrestasi['bobot_penghasilan'] ?? 0.60 ?>" min="0" max="1" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Bobot Tanggungan Ortu</label>
                    <input type="number" name="bobot_tanggungan" class="form-control" value="<?= $bobotPrestasi['bobot_tanggungan'] ?? 0.40 ?>" min="0" max="1" step="0.01" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Bobot Prestasi</button>
        </form>
    </div>

    <!-- Bobot Kurang Mampu -->
    <div class="form-card">
        <h3>Bobot Kriteria - Beasiswa Kurang Mampu</h3>
        <form action="<?= BASE_URL ?>controllers/SettingController.php?action=update_bobot" method="POST">
            <input type="hidden" name="jenis_beasiswa" value="kurang_mampu">
            <div class="form-row">
                <div class="form-group">
                    <label>Bobot Nilai Raport</label>
                    <input type="number" name="bobot_raport" class="form-control" value="<?= $bobotKurangMampu['bobot_raport'] ?? 0.60 ?>" min="0" max="1" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Bobot Penghasilan Ortu</label>
                    <input type="number" name="bobot_penghasilan" class="form-control" value="<?= $bobotKurangMampu['bobot_penghasilan'] ?? 0.80 ?>" min="0" max="1" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Bobot Tanggungan Ortu</label>
                    <input type="number" name="bobot_tanggungan" class="form-control" value="<?= $bobotKurangMampu['bobot_tanggungan'] ?? 0.40 ?>" min="0" max="1" step="0.01" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Bobot Kurang Mampu</button>
        </form>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>
