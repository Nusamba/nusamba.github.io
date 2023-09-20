<?php
session_start();

if( isset($_SESSION["login"])){
    header("location: index.php");
    exit;
}


require 'functions.php';

if( isset($_POST["login"])) {

        $email = $_POST["email"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM user WHERE
        email = '$email' ");

        //cek email
        if( mysqli_num_rows($result) === 1) {

            //cek password
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row["password"]) ){
                //set session
                $_SESSION["login"] = true;

                header("location: index.php");
                exit;
            }
        }

        $error = true;

}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-100">

<div class="flex h-screen justify-center items-center">
    <div class="w-full max-w-xs">

    <img src="nusamba.png" alt="Logo Nusamba" class="mb-4 mx-auto">

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" action="" method="post">
            <h2 class="text-2xl mb-4 text-center font-semibold">Login</h2>

            <?php if( isset($error) ) : ?>
                <p class="text-red-500 text-xs italic mb-4">Email atau Password salah</p>
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                    Email:
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" name="email" type="email" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                    Kata Sandi:
                </label>
                <input class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="password" name="password" type="password" required>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" name="login">
                    Masuk
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-gray-600 text-xs">Belum punya akun? <a class="text-blue-500 hover:text-blue-800" href="registrasi.php">Daftar di sini</a></p>
        </div>
    </div>
</div>

</body>
</html>
