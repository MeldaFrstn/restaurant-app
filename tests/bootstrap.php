<?php
// Inisialisasi koneksi & class untuk testing
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../includes/classes/Pelanggan.php';
require_once __DIR__ . '/../includes/classes/Meja.php';
require_once __DIR__ . '/../includes/classes/Pemesanan.php';

// Helper: cetak status
function assertEqual($actual, $expected, $message = "") {
    if ($actual == $expected) {
        echo "✅ PASS: $message\n";
    } else {
        echo "❌ FAIL: $message — Expected: $expected, Got: $actual\n";
    }
}
?>