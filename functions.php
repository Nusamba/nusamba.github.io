<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root","", "nusamba"); 

//mengambil data dari database  
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc ($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function tambah ($data) {
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $alamat = htmlspecialchars($data['alamat']);
    $no_telp = htmlspecialchars($data['no_telp']);
    $jenis_kelamin =htmlspecialchars( $data['jenis_kelamin']);
    $nominal_kredit =htmlspecialchars( $data['nominal_kredit']);

    $query = "INSERT INTO karyawan
    VALUES
    ('','$nama', '$alamat', '$no_telp', '$jenis_kelamin', '$nominal_kredit')
    ";

mysqli_query($conn, $query);

return mysqli_affected_rows($conn);

}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id");
    
    return mysqli_affected_rows($conn);
}


function ubah($data){

global $conn;

$id = $data['id'];
$nama = htmlspecialchars($data['nama']);
$alamat = htmlspecialchars($data['alamat']);
$no_telp = htmlspecialchars($data['no_telp']);
$jenis_kelamin =htmlspecialchars( $data['jenis_kelamin']);
$nominal_kredit =htmlspecialchars( $data['nominal_kredit']);

$query = "UPDATE karyawan SET
        nama = '$nama',
        alamat = '$alamat',
        no_telp = '$no_telp',
        jenis_kelamin = '$jenis_kelamin',
        nominal_kredit = '$nominal_kredit'
        WHERE id = $id
        ";

mysqli_query($conn, $query);

return mysqli_affected_rows($conn);

}


function cari ($keyword) {
    $query = "SELECT * FROM karyawan
        WHERE
        nama LIKE '%$keyword%' OR
        alamat LIKE '%$keyword%' OR
        no_telp LIKE '%$keyword%' OR
        jenis_kelamin LIKE '%$keyword%' OR
        nominal_kredit LIKE '%$keyword%'
    ";
return query($query);
}

function regist($data) {
    global $conn;

    $nama = strtolower(stripslashes($data["nama"]));
    $email = ($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // cek nama atau email yang sudah ada
    $result = mysqli_query($conn , "SELECT email FROM user WHERE email = '$email'");

    if(mysqli_fetch_assoc($result)) {
        echo "<script>
        alert('Email sudah terdaftar!');
        </script>";
        return false;
    }


    // cek konfirmasi password
    if( $password !== $password2) {
            echo "<script>
            alert('konfirmasi password tidak sesuai!');
            </script>";
            return false;
    }

    // enkripsi password
     $password = password_hash($password, PASSWORD_DEFAULT);



   //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$email', '$password')");

    return mysqli_affected_rows($conn);

}

?>