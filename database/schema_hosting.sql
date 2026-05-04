-- Schema untuk Hosting
-- Sistem Pendukung Keputusan Penerimaan Beasiswa

-- Tabel: users
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel: siswa
CREATE TABLE IF NOT EXISTS siswa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    nis VARCHAR(20) UNIQUE NOT NULL,
    jenis_kelamin ENUM('P', 'L') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    alamat TEXT NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    nilai_raport DECIMAL(5,2) NOT NULL,
    penghasilan_ortu DECIMAL(15,2) NOT NULL,
    tanggungan_ortu INT NOT NULL,
    jenis_beasiswa ENUM('prestasi', 'kurang_mampu') NOT NULL,
    skor_akhir DECIMAL(10,4) DEFAULT 0,
    ranking INT DEFAULT 0,
    status_penerima ENUM('pending', 'diterima', 'ditolak') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel: setting_kuota
CREATE TABLE IF NOT EXISTS setting_kuota (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jenis_beasiswa ENUM('prestasi', 'kurang_mampu') UNIQUE NOT NULL,
    jumlah_kuota INT NOT NULL DEFAULT 0,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel: bobot_kriteria
CREATE TABLE IF NOT EXISTS bobot_kriteria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    jenis_beasiswa ENUM('prestasi', 'kurang_mampu') UNIQUE NOT NULL,
    bobot_raport DECIMAL(3,2) NOT NULL,
    bobot_penghasilan DECIMAL(3,2) NOT NULL,
    bobot_tanggungan DECIMAL(3,2) NOT NULL
);

-- Insert data awal bobot kriteria
INSERT INTO bobot_kriteria (jenis_beasiswa, bobot_raport, bobot_penghasilan, bobot_tanggungan) VALUES
('prestasi', 0.80, 0.60, 0.40),
('kurang_mampu', 0.60, 0.80, 0.40);

-- Insert data awal setting kuota
INSERT INTO setting_kuota (jenis_beasiswa, jumlah_kuota) VALUES
('prestasi', 0),
('kurang_mampu', 0);
