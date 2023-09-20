<?php
session_start();

if( !isset($_SESSION["login"])) {
    header("location: login.php");
    exit;
}

require 'functions.php';
$karyawan = query("SELECT * FROM karyawan");

// tombol cari ditekan
if(isset($_POST["cari"]) ) {
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
    <style>
        /* CSS Kustom */
        .sidebar {
            width: 250px;
            min-width: 250px;
            background-color: #fff;
            color: #FFA500;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }

        .sidebar.show {
            transform: translateX(0);
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-200 to-blue-400">
<!-- Sidebar Nusamba -->
<aside class="sidebar fixed h-screen overflow-y-auto">
    <div class="text-center py-4">
        <img src="nusamba.png" alt="Nusamba Logo" class="w-20 mx-auto">
    </div>
    <ul class="mt-4 space-y-2">
        <li>
            <a class="block py-2 px-4 hover:bg-blue-700" href="tambah.php">Tambah Karyawan</a>
        </li>
        <li>
            <a class="block py-2 px-4 hover:bg-blue-700" href="edit.php">Edit Karyawan</a>
        </li>
        <li>
            <a class="block py-2 px-4 hover:bg-blue-700" href="print.php">Print</a>
        </li>
        <li>
            <button class="block py-2 px-4 hover:bg-blue-700" id="uploadButton">Upload</button>
        </li>
        <li>
            <a class="block py-2 px-4 hover:bg-blue-700" href="logout.php">Logout</a>
        </li>
    </ul>
</aside>

<!-- Tombol Toggle Sidebar -->
<button id="toggleSidebar" class="fixed top-4 left-4 bg-blue-600 text-white py-2 px-4 rounded-full z-10">
    ☰
</button>

<!-- Konten Utama -->
<main class="w-full p-4">
    <!-- Header -->
    <div class="bg-blue-600 text-white p-4">
        <div class="container mx-auto">
            <h1 class="text-2xl font-semibold text-center">Admin Database</h1>
        </div>
    </div>

    <!-- Tampilan Data Karyawan -->
    <form class="text-center my-4" action="" method="post">
        <div class="mb-4">
            <input class="border border-gray-300 rounded px-4 py-2 w-2/3" type="text" name="keyword" size="40" autofocus autocomplete="off" placeholder="Masukkan keyword pencarian">
            <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-full" type="submit" name="cari">Cari</button>
        </div>
    </form>

    <table class="w-full border-collapse border border-gray-300 shadow-md">
        <thead>
            <tr>
                <th class="bg-gray-200 border border-gray-300 px-4 py-2">ID</th>
                <th class="bg-gray-200 border border-gray-300 px-4 py-2">Nama</th>
                <th class="bg-gray-200 border border-gray-300 px-4 py-2">Alamat</th>
                <th class="bg-gray-200 border border-gray-300 px-4 py-2">No. Telp</th>
                <th class="bg-gray-200 border border-gray-300 px-4 py-2">Jenis Kelamin</th>
                <th class="bg-gray-200 border border-gray-300 px-4 py-2">Nominal Kredit</th>
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
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        const uploadButton = document.getElementById("uploadButton");
        const toggleButton = document.getElementById("toggleSidebar");
        const sidebar = document.querySelector('.sidebar');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });

        uploadButton.addEventListener("click", function() {
            const uploadUrl = "upload.php";
            window.open(uploadUrl, "UploadExcelPopup", "width=600,height=400");
        });
    });
</script>

</body>
</html>
