<?php
require_once 'bootstrap.php';

echo " Testing Class Pelanggan...\n";

// Setup: buat pelanggan baru
$p = new Pelanggan("Andi", "andi@example.com", "081234567890");
$success = $p->simpan($pdo);
assertEqual($success, true, "Simpan pelanggan baru");

// Ambil ulang dari DB
$pelangganBaru = Pelanggan::findById($pdo, $pdo->lastInsertId());
assertEqual($pelangganBaru->getNama(), "Andi", "Nama pelanggan sesuai");

// Cleanup (opsional): hapus data test
$pdo->prepare("DELETE FROM pelanggan WHERE id_pelanggan = ?")
    ->execute([$pelangganBaru->getId()]);

echo "\n";
?>