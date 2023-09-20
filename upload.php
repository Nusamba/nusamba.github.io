<?php
// Pastikan sesuai dengan konfigurasi database Anda
$servername = "localhost";
$username = "root";
$password = "";
$database = "nusamba";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    require 'vendor/autoload.php'; // Tambahkan autoload.php untuk PhpSpreadsheet

    // Konfigurasi upload file
    $uploadDir = 'C:\xampp\phpMyAdmin\htdoc\latihan15\uploads'; // Folder tempat Anda akan menyimpan file Excel
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    // Periksa tipe file
    $fileType = pathinfo($uploadFile, PATHINFO_EXTENSION);
    if ($fileType != 'xlsx' && $fileType != 'xls') {
        echo "Hanya file Excel (.xlsx atau .xls) yang diizinkan.";
    } else {
        // Upload file ke server
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            // Baca file Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadFile);
            $worksheet = $spreadsheet->getActiveSheet();
            
            $data = [];

            // Baca data dari file Excel
            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $data[] = $rowData;
            }

            // Simpan data ke tabel karyawan
            foreach ($data as $row) {
                $nama = $row[0];
                $alamat = $row[1];
                $no_telp = $row[2];
                $jenis_kelamin = $row[3];
                $nominal_kredit = $row[4];

                $sql = "INSERT INTO karyawan (nama, alamat, no_telp, jenis_kelamin, nominal_kredit) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $nama, $alamat, $no_telp, $jenis_kelamin, $nominal_kredit);
                $stmt->execute();
            }

            echo "Data berhasil diimpor ke tabel karyawan.";
        } else {
            echo "Upload file gagal.";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel to Database</title>
    <!-- Tambahkan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Tambahkan header -->
    <header class="bg-blue-500 text-white text-center py-4">
        <h1 class="text-3xl font-semibold">Upload Data Excel ke Tabel Karyawan</h1>
        <p>Silakan pilih file Excel (.xlsx atau .xls) untuk diimpor ke database.</p>
    </header>

    <div class="container mx-auto mt-8 p-4 bg-white rounded shadow-lg">
        <!-- Tambahkan form dengan Tailwind CSS -->
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <input type="file" name="file" accept=".xlsx, .xls" class="border p-2 w-full">
            </div>
            <div class="mb-4">
                <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Upload
                </button>
            </div>
        </form>

        <!-- Tampilkan pesan kesalahan atau keberhasilan -->
        <?php
        if (isset($_POST['submit'])) {
            // ...
            if ($fileType != 'xlsx' && $fileType != 'xls') {
                echo '<div class="text-red-500">Hanya file Excel (.xlsx atau .xls) yang diizinkan.</div>';
            } else {
                // Upload file ke server
                if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                    // Baca file Excel
                    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($uploadFile);
                    $worksheet = $spreadsheet->getActiveSheet();
                    
                    $data = [];

                    // Baca data dari file Excel
                    foreach ($worksheet->getRowIterator() as $row) {
                        $rowData = [];
                        foreach ($row->getCellIterator() as $cell) {
                            $rowData[] = $cell->getValue();
                        }
                        $data[] = $rowData;
                    }

                    // Simpan data ke tabel karyawan
                    foreach ($data as $row) {
                        $nama = $row[0];
                        $alamat = $row[1];
                        $no_telp = $row[2];
                        $jenis_kelamin = $row[3];
                        $nominal_kredit = $row[4];

                        $sql = "INSERT INTO karyawan (nama, alamat, no_telp, jenis_kelamin, nominal_kredit) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sssss", $nama, $alamat, $no_telp, $jenis_kelamin, $nominal_kredit);
                        $stmt->execute();
                    }

                } 
            }
        }
        ?>
    </div>
</body>
</html>

