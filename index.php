<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Restoran - Daftar Pemesanan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Sistem Pemesanan Restoran</h1>

    <a href="add_booking.php" class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-700">+ Tambah Pemesanan</a>

    <div class="mt-6 bg-white shadow rounded p-4">
      <h2 class="text-xl font-semibold mb-4">Daftar Pemesanan</h2>
      <table class="min-w-full divide-y">
        <thead>
          <tr class="bg-gray-50">
            <th class="px-4 py-2 text-left">Pelanggan</th>
            <th class="px-4 py-2 text-left">Meja</th>
            <th class="px-4 py-2 text-left">Tanggal & Waktu</th>
            <th class="px-4 py-2 text-left">Jumlah</th>
            <th class="px-4 py-2 text-left">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <?php
          require 'includes/database.php';
          require 'includes/classes/Pemesanan.php';
          $daftar = Pemesanan::getAllWithDetails($pdo);
          foreach ($daftar as $p) {
            echo "<tr>
              <td class='px-4 py-2'>{$p['pelanggan']}</td>
              <td class='px-4 py-2'>Meja {$p['nomor_meja']}</td>
              <td class='px-4 py-2'>{$p['tanggal']} {$p['waktu']}</td>
              <td class='px-4 py-2'>{$p['jumlah_orang']}</td>
              <td class='px-4 py-2'>
                <a href='edit_booking.php?id={$p['id_pemesanan']}' class='text-blue-600 hover:underline mr-3'>Edit</a>
                <a href='delete_booking.php?id={$p['id_pemesanan']}' class='text-red-600 hover:underline' onclick=\"return confirm('Yakin hapus?')\">Hapus</a>
              </td>
            </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
