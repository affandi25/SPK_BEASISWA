<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../includes/session.php';
requireLogin();
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - SPK Beasiswa</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>
<?php include __DIR__ . '/../partials/navbar.php'; ?>
<div class="container">
    <div class="page-header">
        <h2>Tambah Data Siswa</h2>
        <a href="<?= BASE_URL ?>views/siswa/index.php" class="btn btn-secondary">← Kembali</a>
    </div>
    <?php if ($flash): ?>
        <div class="alert alert-<?= $flash['type'] ?>"><?= htmlspecialchars($flash['message']) ?></div>
    <?php endif; ?>
    <div class="form-card">
        <form action="<?= BASE_URL ?>controllers/SiswaController.php?action=store" method="POST" id="formSiswa">
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>NIS *</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin *</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label>Alamat *</label>
                <textarea name="alamat" class="form-control" rows="2" required></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Kelas *</label>
                    <input type="text" name="kelas" class="form-control" placeholder="Contoh: X IPA 1" required>
                </div>
                <div class="form-group">
                    <label>Jenis Beasiswa *</label>
                    <select name="jenis_beasiswa" class="form-control" required>
                        <option value="">-- Pilih --</option>
                        <option value="prestasi">Prestasi</option>
                        <option value="kurang_mampu">Kurang Mampu</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Nilai Raport (0-100) *</label>
                    <input type="number" name="nilai_raport" class="form-control" min="0" max="100" step="0.01" required>
                </div>
                <div class="form-group">
                    <label>Penghasilan Orang Tua (Rp) *</label>
                    <input type="number" name="penghasilan_ortu" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                    <label>Tanggungan Orang Tua *</label>
                    <input type="number" name="tanggungan_ortu" class="form-control" min="0" required>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= BASE_URL ?>views/siswa/index.php" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/validation.js"></script>
</body>
</html>
