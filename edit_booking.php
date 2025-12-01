<?php
require 'includes/database.php';
require 'includes/classes/Pemesanan.php';
require 'includes/classes/Meja.php';

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: index.php"); exit; }

// Ambil data
$pemesanan = Pemesanan::findById($pdo, $id);
$meja_lama = $pemesanan['id_meja'];
if (!$pemesanan) { die("Pemesanan tidak ditemukan."); }

$pelanggan = $pdo->prepare("SELECT * FROM pelanggan WHERE id_pelanggan = ?");
$pelanggan->execute([$pemesanan['id_pelanggan']]);
$pel = $pelanggan->fetch();

if ($_POST) {
    // Update pelanggan
    $stmt = $pdo->prepare("UPDATE pelanggan SET nama = ?, email = ?, telepon = ? WHERE id_pelanggan = ?");
    $stmt->execute([$_POST['nama'], $_POST['email'], $_POST['telepon'], $pemesanan['id_pelanggan']]);

    // Jika meja berubah, kembalikan status lama & update yang baru
    if ($_POST['id_meja'] != $meja_lama) {
        Meja::setStatus($pdo, $meja_lama, 'tersedia');
        Meja::setStatus($pdo, $_POST['id_meja'], 'dipesan');
    }

    // Update pemesanan
    $stmt = $pdo->prepare("UPDATE pemesanan SET id_meja = ?, tanggal = ?, waktu = ?, jumlah_orang = ? WHERE id_pemesanan = ?");
    $stmt->execute([$_POST['id_meja'], $_POST['tanggal'], $_POST['waktu'], $_POST['jumlah'], $id]);

    header("Location: index.php?status=updated");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Pemesanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Edit Pemesanan</h2>
    <form method="POST" class="bg-white p-6 rounded shadow">
      <div class="mb-4"><label class="block mb-1">Nama Pelanggan</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($pel['nama']) ?>" required class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($pel['email']) ?>" class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Telepon</label>
        <input type="text" name="telepon" value="<?= htmlspecialchars($pel['telepon']) ?>" class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Tanggal & Waktu</label>
        <input type="date" name="tanggal" value="<?= $pemesanan['tanggal'] ?>" required class="p-2 border rounded mr-2">
        <input type="time" name="waktu" value="<?= substr($pemesanan['waktu'], 0, 5) ?>" required class="p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Jumlah Orang</label>
        <input type="number" name="jumlah" value="<?= $pemesanan['jumlah_orang'] ?>" min="1" max="10" required class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Pilih Meja</label>
        <select name="id_meja" required class="w-full p-2 border rounded">
          <?php foreach (Meja::getAll($pdo) as $m): ?>
            <option value="<?= $m['id_meja'] ?>" <?= $m['id_meja'] == $pemesanan['id_meja'] ? 'selected' : '' ?>>
              Meja <?= $m['nomor_meja'] ?> (Kapasitas: <?= $m['kapasitas'] ?>, <?= $m['status'] ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
      <a href="index.php" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
  </div>
</body>
</html>