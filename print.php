<?php
require 'functions.php';

// Inisialisasi variabel pencarian
$keyword = '';
$karyawan = query("SELECT * FROM karyawan");

// Cek jika tombol "Cari" diklik
if (isset($_GET['search'])) {
    $keyword = $_GET['keyword'];
    $karyawan = cari($keyword);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        .print-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
        @media print {
        .search-form, 
        .print-button, 
        .back-button,
        .pilih { 
            display: none;
        }
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data Karyawan</h1>

        <!-- Kolom pencarian -->
        <form class="search-form" action="" method="get">
            <input type="text" name="keyword" value="<?= $keyword; ?>" placeholder="Cari Nama Karyawan">
            <button type="submit" name="search">Cari</button>
        </form>
        <form action="cetak_data.php" method="post">
        <table>
            <thead>
                <tr>
                    <th class="pilih">Pilih</th>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Jenis Kelamin</th>
                    <th>Nominal Kredit</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($karyawan as $row) : ?>
        <tr>
            <td class="pilih"><input type="checkbox" name="selected_ids[]" value="<?= $row['id']; ?>"></td>
            <td><?= $row["id"]; ?></td>
            <td><?= $row["nama"]; ?></td>
            <td><?= $row["alamat"]; ?></td>
            <td><?= $row["no_telp"]; ?></td>
            <td><?= $row["jenis_kelamin"]; ?></td>
            <td>Rp<?= number_format($row["nominal_kredit"], 2, ',', '.'); ?></td>
        </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a class="back-button" href="index.php">Kembali</a>
        <button class="print-button" type="submit" name="print">Cetak Data yang Dipilih</button>
</form>
    </div>
    <script>
    function printSelectedData() {
    var selectedIds = [];
    var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]:checked');
    
    checkboxes.forEach(function(checkbox) {
        selectedIds.push(checkbox.value);
    });

    if (selectedIds.length > 0) {
        var printForm = document.getElementById('print-form');
        var selectedIdsInput = document.createElement('input');
        selectedIdsInput.type = 'hidden';
        selectedIdsInput.name = 'selected_ids';
        selectedIdsInput.value = JSON.stringify(selectedIds);
        printForm.appendChild(selectedIdsInput);

        printForm.submit();
    } else {
        alert('Pilih setidaknya satu karyawan untuk mencetak.');
    }
}
</script>
</body>
</html>
