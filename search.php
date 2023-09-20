<?php
require 'functions.php';

$keyword = $_GET['keyword'];
$karyawan = cari($keyword);

// Format hasil pencarian sebagai JSON
header('Content-Type: application/json');
echo json_encode($karyawan);
