<?php
class Setting {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getKuota($jenis_beasiswa = null) {
        if ($jenis_beasiswa) {
            $stmt = $this->pdo->prepare("SELECT * FROM setting_kuota WHERE jenis_beasiswa = ?");
            $stmt->execute([$jenis_beasiswa]);
            return $stmt->fetch();
        }
        return $this->pdo->query("SELECT * FROM setting_kuota")->fetchAll();
    }

    public function updateKuota($jenis_beasiswa, $jumlah) {
        $stmt = $this->pdo->prepare("UPDATE setting_kuota SET jumlah_kuota = ? WHERE jenis_beasiswa = ?");
        return $stmt->execute([$jumlah, $jenis_beasiswa]);
    }

    public function getBobot($jenis_beasiswa) {
        $stmt = $this->pdo->prepare("SELECT * FROM bobot_kriteria WHERE jenis_beasiswa = ?");
        $stmt->execute([$jenis_beasiswa]);
        return $stmt->fetch();
    }

    public function updateBobot($jenis_beasiswa, $raport, $penghasilan, $tanggungan) {
        $stmt = $this->pdo->prepare("UPDATE bobot_kriteria SET bobot_raport=?, bobot_penghasilan=?, bobot_tanggungan=? WHERE jenis_beasiswa=?");
        return $stmt->execute([$raport, $penghasilan, $tanggungan, $jenis_beasiswa]);
    }
}
