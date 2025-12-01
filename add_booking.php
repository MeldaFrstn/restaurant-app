<?php
require 'includes/database.php';
require 'includes/classes/Meja.php';

if ($_POST) {
    require 'includes/classes/Pelanggan.php';
    require 'includes/classes/Pemesanan.php';

    // Simpan pelanggan
    $pelanggan = new Pelanggan($_POST['nama'], $_POST['email'], $_POST['telepon']);
    $pelanggan->simpan($pdo);
    $id_pelanggan = $pdo->lastInsertId();

    // Simpan pemesanan
    $pemesanan = new Pemesanan(
        $id_pelanggan,
        $_POST['id_meja'],
        $_POST['tanggal'],
        $_POST['waktu'],
        $_POST['jumlah']
    );
    $pemesanan->simpan($pdo);

    header("Location: index.php?status=success");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Tambah Pemesanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-4">Tambah Pemesanan Baru</h2>
    <form method="POST" class="bg-white p-6 rounded shadow">
      <div class="mb-4"><label class="block mb-1">Nama Pelanggan</label>
        <input type="text" name="nama" required class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Email</label>
        <input type="email" name="email" class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Telepon</label>
        <input type="text" name="telepon" class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Tanggal & Waktu</label>
        <input type="date" name="tanggal" required class="p-2 border rounded mr-2">
        <input type="time" name="waktu" required class="p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Jumlah Orang</label>
        <input type="number" name="jumlah" min="1" max="10" required class="w-full p-2 border rounded">
      </div>
      <div class="mb-4"><label class="block mb-1">Pilih Meja</label>
        <select name="id_meja" required class="w-full p-2 border rounded">
          <?php foreach (Meja::getTersedia($pdo) as $m): ?>
            <option value="<?= $m['id_meja'] ?>">Meja <?= $m['nomor_meja'] ?> (Kapasitas: <?= $m['kapasitas'] ?>)</option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
      <a href="index.php" class="ml-2 text-gray-600 hover:underline">Batal</a>
    </form>
  </div>
</body>
</html>