<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../models/Siswa.php';

requireLogin();

$id = (int)($_GET['id'] ?? 0);
$siswaModel = new Siswa($pdo);
$siswa = $siswaModel->findById($id);

if (!$siswa) {
    setFlash('error', 'Data siswa tidak ditemukan.');
    header('Location: ' . BASE_URL . 'views/siswa/index.php');
    exit();
}
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
    <div class="page-header">
        <h2>Edit Data Siswa</h2>
        <a href="<?= BASE_URL ?>views/siswa/index.php" class="btn btn-secondary">← Kembali</a>
    </div>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>
    <div class="form-card">
        <form action="<?= BASE_URL ?>controllers/SiswaController.php?action=update" method="POST" id="formSiswa">
            <input type="hidden" name="id" value="<?= $siswa['id'] ?>">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
                </div>
                <div class="form-group">
                    <label>NIS *</label>
                    <input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($siswa['nis']) ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="L" <?= $siswa['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= $siswa['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= $siswa['tanggal_lahir'] ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label>Alamat *</label>
                <textarea name="alamat" class="form-control" rows="2" required><?= htmlspecialchars($siswa['alamat']) ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Kelas *</label>
                    <input type="text" name="kelas" class="form-control" value="<?= htmlspecialchars($siswa['kelas']) ?>" required>
                </div>
                <div class="form-group">
                    <label>Jenis Beasiswa *</label>
                    <select name="jenis_beasiswa" class="form-control" required>
                        <option value="prestasi" <?= $siswa['jenis_beasiswa'] === 'prestasi' ? 'selected' : '' ?>>Prestasi</option>
                        <option value="kurang_mampu" <?= $siswa['jenis_beasiswa'] === 'kurang_mampu' ? 'selected' : '' ?>>Kurang Mampu</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nilai Raport (0-100) *</label>
                    <input type="number" name="nilai_raport" class="form-control" value="<?= $siswa['nilai_raport'] ?>" min="0" max="100" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Penghasilan Orang Tua (Rp) *</label>
                    <input type="number" name="penghasilan_ortu" class="form-control" value="<?= $siswa['penghasilan_ortu'] ?>" min="0" required>
                </div>
                <div class="form-group">
                    <label>Tanggungan Orang Tua *</label>
                    <input type="number" name="tanggungan_ortu" class="form-control" value="<?= $siswa['tanggungan_ortu'] ?>" min="0" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Perbarui</button>
                <a href="<?= BASE_URL ?>views/siswa/index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/validation.js"></script>
</body>
</html>
