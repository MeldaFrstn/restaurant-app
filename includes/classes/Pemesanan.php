<?php
class Pemesanan {
    private $id;
    private $id_pelanggan;
    private $id_meja;
    private $tanggal;
    private $waktu;
    private $jumlah_orang;

    public function __construct($id_pelanggan, $id_meja, $tanggal, $waktu, $jumlah, $id = null) {
        $this->id = $id;
        $this->id_pelanggan = $id_pelanggan;
        $this->id_meja = $id_meja;
        $this->tanggal = $tanggal;
        $this->waktu = $waktu;
        $this->jumlah_orang = $jumlah;
    }

    public function getId() { return $this->id; }

    public function simpan($pdo) {
        if ($this->id) {
            // Edit
            $stmt = $pdo->prepare("UPDATE pemesanan SET id_pelanggan = ?, id_meja = ?, tanggal = ?, waktu = ?, jumlah_orang = ? WHERE id_pemesanan = ?");
            return $stmt->execute([$this->id_pelanggan, $this->id_meja, $this->tanggal, $this->waktu, $this->jumlah_orang, $this->id]);
        } else {
            // Tambah
            $stmt = $pdo->prepare("INSERT INTO pemesanan (id_pelanggan, id_meja, tanggal, waktu, jumlah_orang) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$this->id_pelanggan, $this->id_meja, $this->tanggal, $this->waktu, $this->jumlah_orang]);
            $this->id = $pdo->lastInsertId();

            // Update status meja
            Meja::setStatus($pdo, $this->id_meja, 'dipesan');
            return true;
        }
    }

    public static function getAllWithDetails($pdo) {
        $stmt = $pdo->query("
            SELECT p.*, pel.nama AS pelanggan, m.nomor_meja, m.kapasitas
            FROM pemesanan p
            JOIN pelanggan pel ON p.id_pelanggan = pel.id_pelanggan
            JOIN meja m ON p.id_meja = m.id_meja
            ORDER BY p.tanggal DESC, p.waktu DESC
        ");
        return $stmt->fetchAll();
    }

    public static function findById($pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM pemesanan WHERE id_pemesanan = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public static function hapus($pdo, $id) {
        // Dapatkan id_meja dulu
        $stmt = $pdo->prepare("SELECT id_meja FROM pemesanan WHERE id_pemesanan = ?");
        $stmt->execute([$id]);
        $meja = $stmt->fetch();
        if ($meja) {
            // Hapus pemesanan
            $pdo->prepare("DELETE FROM pemesanan WHERE id_pemesanan = ?")->execute([$id]);
            // Kembalikan status meja
            Meja::setStatus($pdo, $meja['id_meja'], 'tersedia');
            return true;
        }
        return false;
    }
}
?>