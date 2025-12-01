<?php
class Pelanggan {
    private $id;
    private $nama;
    private $email;
    private $telepon;

    public function __construct($nama, $email = null, $telepon = null, $id = null) {
        $this->id = $id;
        $this->nama = $nama;
        $this->email = $email;
        $this->telepon = $telepon;
    }

    public function getId() { return $this->id; }
    public function getNama() { return $this->nama; }
    public function getEmail() { return $this->email; }
    public function getTelepon() { return $this->telepon; }

    public function simpan($pdo) {
        if ($this->id) {
            $stmt = $pdo->prepare("UPDATE pelanggan SET nama = ?, email = ?, telepon = ? WHERE id_pelanggan = ?");
            return $stmt->execute([$this->nama, $this->email, $this->telepon, $this->id]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO pelanggan (nama, email, telepon) VALUES (?, ?, ?)");
            $stmt->execute([$this->nama, $this->email, $this->telepon]);
            $this->id = $pdo->lastInsertId();
            return true;
        }
    }

    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        if ($data) {
            return new self($data['nama'], $data['email'], $data['telepon'], $data['id_pelanggan']);
        }
        return null;
    }
}
?>