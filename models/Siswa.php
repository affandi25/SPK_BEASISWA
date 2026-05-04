<?php
class Siswa {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll($jenis_beasiswa = null) {
        $sql = "SELECT * FROM siswa";
        $params = [];
        if ($jenis_beasiswa) {
            $sql .= " WHERE jenis_beasiswa = ?";
            $params[] = $jenis_beasiswa;
        }
        $sql .= " ORDER BY ranking ASC, nama ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM siswa WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO siswa 
            (nama, nis, jenis_kelamin, tanggal_lahir, alamat, kelas, nilai_raport, penghasilan_ortu, tanggungan_ortu, jenis_beasiswa)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nama'], $data['nis'], $data['jenis_kelamin'], $data['tanggal_lahir'],
            $data['alamat'], $data['kelas'], $data['nilai_raport'],
            $data['penghasilan_ortu'], $data['tanggungan_ortu'], $data['jenis_beasiswa']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare("UPDATE siswa SET 
            nama=?, nis=?, jenis_kelamin=?, tanggal_lahir=?, alamat=?, kelas=?,
            nilai_raport=?, penghasilan_ortu=?, tanggungan_ortu=?, jenis_beasiswa=?
            WHERE id=?");
        return $stmt->execute([
            $data['nama'], $data['nis'], $data['jenis_kelamin'], $data['tanggal_lahir'],
            $data['alamat'], $data['kelas'], $data['nilai_raport'],
            $data['penghasilan_ortu'], $data['tanggungan_ortu'], $data['jenis_beasiswa'], $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM siswa WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function countByJenis($jenis_beasiswa) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM siswa WHERE jenis_beasiswa = ?");
        $stmt->execute([$jenis_beasiswa]);
        return $stmt->fetchColumn();
    }

    public function countDiterima($jenis_beasiswa) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM siswa WHERE jenis_beasiswa = ? AND status_penerima = 'diterima'");
        $stmt->execute([$jenis_beasiswa]);
        return $stmt->fetchColumn();
    }

    public function updateRankingStatus($id, $skor, $ranking, $status) {
        $stmt = $this->pdo->prepare("UPDATE siswa SET skor_akhir=?, ranking=?, status_penerima=? WHERE id=?");
        return $stmt->execute([$skor, $ranking, $status, $id]);
    }

    public function getAllByJenisOrderedByNilai($jenis_beasiswa) {
        $stmt = $this->pdo->prepare("SELECT * FROM siswa WHERE jenis_beasiswa = ?");
        $stmt->execute([$jenis_beasiswa]);
        return $stmt->fetchAll();
    }
}
