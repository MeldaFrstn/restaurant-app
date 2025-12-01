<?php
require_once 'bootstrap.php';

echo "Testing Class Meja...\n";

// Pastikan ada meja tersedia di DB (jika tidak, test gagal → bagian dari validasi!)
$mejaList = Meja::getTersedia($pdo);
assertEqual(count($mejaList) > 0, true, "Ada meja dengan status 'tersedia'");

// Ambil satu meja
$meja = $mejaList[0];
assertEqual(isset($meja['id_meja']), true, "Meja memiliki id_meja");

// Coba ubah status
$success = Meja::setStatus($pdo, $meja['id_meja'], 'dipesan');
assertEqual($success, true, "Update status meja ke 'dipesan'");

// Kembalikan status
Meja::setStatus($pdo, $meja['id_meja'], 'tersedia');

echo "\n";
?>