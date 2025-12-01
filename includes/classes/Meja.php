<?php
class Meja {
    private $id;
    private $nomor;
    private $kapasitas;

    public function __construct($nomor, $kapasitas, $id = null) {
        $this->id = $id;
        $this->nomor = $nomor;
        $this->kapasitas = $kapasitas;
    }

    public function getId() { return $this->id; }
    public function getNomor() { return $this->nomor; }

    public static function getTersedia($pdo) {
        $stmt = $pdo->query("SELECT * FROM meja WHERE status = 'tersedia'");
        return $stmt->fetchAll();
    }

    public static function getAll($pdo) {
        $stmt = $pdo->query("SELECT * FROM meja");
        return $stmt->fetchAll();
    }

    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM meja WHERE id_meja = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function setStatus($pdo, $id_meja, $status) {
        $stmt = $pdo->prepare("UPDATE meja SET status = ? WHERE id_meja = ?");
        return $stmt->execute([$status, $id_meja]);
    }
}
?>