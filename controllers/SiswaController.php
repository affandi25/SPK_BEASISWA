<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../models/Siswa.php';

requireLogin();

$action = $_GET['action'] ?? 'index';
$siswaModel = new Siswa($pdo);

function validateSiswa($data) {
    $errors = [];
    if (empty($data['nama'])) $errors[] = 'Nama wajib diisi.';
    if (empty($data['nis'])) $errors[] = 'NIS wajib diisi.';
    if (!in_array($data['jenis_kelamin'], ['P', 'L'])) $errors[] = 'Jenis kelamin tidak valid.';
    if (empty($data['tanggal_lahir'])) $errors[] = 'Tanggal lahir wajib diisi.';
    if (empty($data['alamat'])) $errors[] = 'Alamat wajib diisi.';
    if (empty($data['kelas'])) $errors[] = 'Kelas wajib diisi.';
    if (!is_numeric($data['nilai_raport']) || $data['nilai_raport'] < 0 || $data['nilai_raport'] > 100)
        $errors[] = 'Nilai raport harus angka 0-100.';
    if (!is_numeric($data['penghasilan_ortu']) || $data['penghasilan_ortu'] < 0)
        $errors[] = 'Penghasilan orang tua tidak valid.';
    if (!is_numeric($data['tanggungan_ortu']) || $data['tanggungan_ortu'] < 0)
        $errors[] = 'Tanggungan orang tua tidak valid.';
    if (!in_array($data['jenis_beasiswa'], ['prestasi', 'kurang_mampu']))
        $errors[] = 'Jenis beasiswa tidak valid.';
    return $errors;
}

if ($action === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama'            => trim($_POST['nama'] ?? ''),
        'nis'             => trim($_POST['nis'] ?? ''),
        'jenis_kelamin'   => $_POST['jenis_kelamin'] ?? '',
        'tanggal_lahir'   => $_POST['tanggal_lahir'] ?? '',
        'alamat'          => trim($_POST['alamat'] ?? ''),
        'kelas'           => trim($_POST['kelas'] ?? ''),
        'nilai_raport'    => $_POST['nilai_raport'] ?? '',
        'penghasilan_ortu'=> $_POST['penghasilan_ortu'] ?? '',
        'tanggungan_ortu' => $_POST['tanggungan_ortu'] ?? '',
        'jenis_beasiswa'  => $_POST['jenis_beasiswa'] ?? '',
    ];
    $errors = validateSiswa($data);
    if ($errors) {
        setFlash('error', implode(' ', $errors));
    } else {
        try {
            $siswaModel->create($data);
            setFlash('success', 'Data siswa berhasil ditambahkan.');
        } catch (PDOException $e) {
            setFlash('error', 'NIS sudah terdaftar.');
        }
    }
    header('Location: ' . BASE_URL . 'views/siswa/index.php');
    exit();
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $data = [
        'nama'            => trim($_POST['nama'] ?? ''),
        'nis'             => trim($_POST['nis'] ?? ''),
        'jenis_kelamin'   => $_POST['jenis_kelamin'] ?? '',
        'tanggal_lahir'   => $_POST['tanggal_lahir'] ?? '',
        'alamat'          => trim($_POST['alamat'] ?? ''),
        'kelas'           => trim($_POST['kelas'] ?? ''),
        'nilai_raport'    => $_POST['nilai_raport'] ?? '',
        'penghasilan_ortu'=> $_POST['penghasilan_ortu'] ?? '',
        'tanggungan_ortu' => $_POST['tanggungan_ortu'] ?? '',
        'jenis_beasiswa'  => $_POST['jenis_beasiswa'] ?? '',
    ];
    $errors = validateSiswa($data);
    if ($errors) {
        setFlash('error', implode(' ', $errors));
    } else {
        try {
            $siswaModel->update($id, $data);
            setFlash('success', 'Data siswa berhasil diperbarui.');
        } catch (PDOException $e) {
            setFlash('error', 'NIS sudah digunakan siswa lain.');
        }
    }
    header('Location: ' . BASE_URL . 'views/siswa/index.php');
    exit();
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    requireAdmin();
    $id = (int)($_POST['id'] ?? 0);
    $siswaModel->delete($id);
    setFlash('success', 'Data siswa berhasil dihapus.');
    header('Location: ' . BASE_URL . 'views/siswa/index.php');
    exit();
}
