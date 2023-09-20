<?php
require('fpdf.php'); // Gantilah dengan path yang sesuai ke FPDF

if (isset($_POST['print']) && isset($_POST['selected_ids'])) {
    // Koneksi ke database (gunakan informasi koneksi yang sudah Anda sediakan di functions.php)
    require 'functions.php';

    // Fungsi untuk mengambil data berdasarkan ID yang dipilih
    function getDataByIds($selectedIds) {
        global $conn;
        $ids = implode(',', $selectedIds);
        $query = "SELECT * FROM karyawan WHERE id IN ($ids)";
        $result = mysqli_query($conn, $query);
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }

    // Mengambil data yang dipilih dari database
    $selectedIds = $_POST['selected_ids'];
    $selectedData = getDataByIds($selectedIds);

    // Membuat dokumen PDF
    $pdf = new FPDF('P', 'mm', 'A4'); // 'P' untuk orientasi potrait
    $pdf->SetAutoPageBreak(true, 10); // Mengatur lompatan otomatis ke halaman baru setiap 10mm
    $pdf->SetLeftMargin(0); // Mengatur margin kiri ke 0
    $pdf->AddPage();

    // Tampilan Header
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Data Karyawan', 0, 1, 'C');

    // Tabel
    $pdf->SetFont('Arial', 'B', 12);
    
    // Lebar kolom-kolom diperbesar
    $pdf->Cell(20, 10, 'ID', 1);
    
    // Lebar kolom "Nama" diperbesar
    $pdf->Cell(60, 10, 'Nama', 1);
    
    $pdf->Cell(40, 10, 'Alamat', 1);
    $pdf->Cell(30, 10, 'No. Telp', 1);
    $pdf->Cell(20, 10, 'Gender', 1);
    $pdf->Cell(40, 10, 'Nominal', 1);
    $pdf->Ln();

    // Isi Tabel
    foreach ($selectedData as $row) {
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(20, 10, $row['id'], 1);
        
        // Lebar kolom "Nama" diperbesar
        $pdf->Cell(60, 10, $row['nama'], 1);
        
        $pdf->Cell(40, 10, $row['alamat'], 1);
        $pdf->Cell(30, 10, $row['no_telp'], 1);
        $pdf->Cell(20, 10, $row['jenis_kelamin'], 1);
        $pdf->Cell(40, 10, 'Rp ' . number_format($row['nominal_kredit'], 2, ',', '.'), 1);
        $pdf->Ln();
    }

    // Output PDF ke browser
    $pdf->Output();
}
?>
