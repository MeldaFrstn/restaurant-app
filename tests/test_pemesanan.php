<?php
require_once 'bootstrap.php';

echo "Testing Class Pemesanan...\n";

// 1. Buat pelanggan dulu
$pel = new Pelanggan("Budi Test", "budi@test.com");
$pel->simpan($pdo);
$id_pel = $pdo->lastInsertId();

// 2. Ambil meja tersedia
$mejaTersedia = Meja::getTersedia($pdo);
if (empty($mejaTersedia)) {
    echo "❌ FAIL: Tidak ada meja tersedia untuk test pemesanan!\n\n";
    exit(1);
}
$id_meja = $mejaTersedia[0]['id_meja'];

// 3. Buat pemesanan
$tgl = date('Y-m-d');
$wkt = '19:00:00';
$pesan = new Pemesanan($id_pel, $id_meja, $tgl, $wkt, 2);
$success = $pesan->simpan($pdo);
assertEqual($success, true, "Simpan pemesanan berhasil");

// 4. Cek status meja berubah
$stmt = $pdo->prepare("SELECT status FROM meja WHERE id_meja = ?");
$stmt->execute([$id_meja]);
$status = $stmt->fetch()['status'];
assertEqual($status, 'dipesan', "Status meja berubah menjadi 'dipesan'");

// 5. Hapus pemesanan (test hapus)
$id_pesan = $pesan->getId();
$hapus = Pemesanan::hapus($pdo, $id_pesan);
assertEqual($hapus, true, "Hapus pemesanan berhasil");

// 6. Cek status meja kembali ke 'tersedia'
$stmt->execute([$id_meja]);
$statusBaru = $stmt->fetch()['status'];
assertEqual($statusBaru, 'tersedia', "Status meja kembali ke 'tersedia'");

// Cleanup
$pdo->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?")->execute([$id_pel]);

echo "\n";
?>