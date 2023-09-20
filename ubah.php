<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

require 'functions.php';

// Ambil data dari URL
$id = $_GET["id"];

// Query data karyawan berdasarkan id
$karyawan = query("SELECT * FROM karyawan WHERE id = $id")[0];

// Cek tombol submit
if (isset($_POST["submit"])) {
    // Query untuk mengubah data
    if (ubah($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil diubah');
            document.location.href = 'index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data gagal diubah');
            document.location.href = 'index.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-md rounded-lg p-8 w-96">
            <h1 class="text-2xl font-semibold mb-6 text-center">Ubah Data Karyawan</h1>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $karyawan["id"]; ?>">
                <div class="mb-4">
                    <label for="nama" class="block text-gray-700 font-bold mb-2">Nama:</label>
                    <input type="text" id="nama" name="nama" class="border border-gray-300 rounded px-4 py-2 w-full" required value="<?= $karyawan["nama"]; ?>">
                </div>
                <div class="mb-4">
                    <label for="alamat" class="block text-gray-700 font-bold mb-2">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" class="border border-gray-300 rounded px-4 py-2 w-full" required value="<?= $karyawan["alamat"]; ?>">
                </div>
                <div class="mb-4">
                    <label for="no_telp" class="block text-gray-700 font-bold mb-2">No. Telp:</label>
                    <input type="text" id="no_telp" name="no_telp" class="border border-gray-300 rounded px-4 py-2 w-full" required value="<?= $karyawan["no_telp"]; ?>">
                </div>
                <div class="mb-4">
                    <label for="jenis_kelamin" class="block text-gray-700 font-bold mb-2">Jenis Kelamin:</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" class="border border-gray-300 rounded px-4 py-2 w-full" required>
                        <option value="Laki-laki" <?= ($karyawan["jenis_kelamin"] === "Laki-laki") ? "selected" : ""; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= ($karyawan["jenis_kelamin"] === "Perempuan") ? "selected" : ""; ?>>Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="nominal_kredit" class="block text-gray-700 font-bold mb-2">Nominal Kredit (Rp):</label>
                    <input type="text" id="nominal_kredit" name="nominal_kredit" class="border border-gray-300 rounded px-4 py-2 w-full" required value="<?= $karyawan["nominal_kredit"]; ?>">
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Ubah Data</button>
                    <a class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded ml-2" href="index.php">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
