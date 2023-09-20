<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

require 'functions.php';
$karyawan = query("SELECT * FROM karyawan");

// Tombol cari ditekan
if (isset($_POST["cari"])) {
    $karyawan = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Database</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="bg-blue-600 text-white py-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-semibold text-center">Edit Database</h1>
        </div>
    </div>
    <div class="container mx-auto mt-6 p-4">
        <a class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded" href="index.php">Kembali</a>
        <div class="mt-4">
            <form action="" method="post">
                <div class="flex justify-center">
                    <input class="border border-gray-300 rounded-l px-4 py-2 w-2/3" type="text" name="keyword" size="40" autofocus autocomplete="off" placeholder="Masukkan keyword pencarian">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-r" type="submit" name="cari">Cari</button>
                </div>
            </form>
        </div>
        <table class="w-full mt-4 bg-white shadow-md rounded-md overflow-x-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2">No. Telp</th>
                    <th class="border border-gray-300 px-4 py-2">Jenis Kelamin</th>
                    <th class="border border-gray-300 px-4 py-2">Nominal Kredit</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($karyawan as $row) : ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?= $i; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row["nama"]; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row["alamat"]; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row["no_telp"]; ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $row["jenis_kelamin"]; ?></td>
                        <td class="border border-gray-300 px-4 py-2">Rp <?= number_format($row["nominal_kredit"], 2, ',', '.'); ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="ubah.php?id=<?= $row["id"]; ?>" class="text-blue-500 hover:text-blue-700">Ubah</a>
                            <a href="hapus.php?id=<?= $row["id"]; ?>" class="text-red-500 hover:text-red-700 ml-2" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
