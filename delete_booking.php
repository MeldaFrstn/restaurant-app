<?php
require 'includes/database.php';
require 'includes/classes/Pemesanan.php';
require 'includes/classes/Meja.php';

$id = $_GET['id'] ?? null;
if ($id && Pemesanan::hapus($pdo, $id)) {
    header("Location: index.php?status=deleted");
} else {
    header("Location: index.php?error=gagal_hapus");
}
exit;
?>