<?php
// Cek apakah user sudah login
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');  // Jika sudah login, arahkan ke dashboard
    exit();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="path_to_css/style.css">
    <title>Halaman Utama</title>
  </head>
  <body>
    <h1>Selamat datang di Sistem Manajemen</h1>
    <a href="views/auth/login.php">Masuk</a> | <a href="views/auth/register.php">Daftar</a>
  </body>
</html>
