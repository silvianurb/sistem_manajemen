<!-- views/pelanggan/delete.php -->
<?php
session_start();
include('../config/config.php');

// Cek apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../views/auth/login.php');
    exit();
}

// Proses hapus data pelanggan
$id = $_GET['id'];
$query = "DELETE FROM pelanggan WHERE idpelanggan = '$id'";
if (mysqli_query($bebas, $query)) {
    header('Location: index.php');
    exit();
} else {
    echo "Error: " . mysqli_error($bebas);
}
?>
