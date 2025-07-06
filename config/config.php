<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = mysqli_connect('localhost', 'root', '', 'dbsistem');
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi proteksi akses
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['error_message'] = 'Akses tidak diizinkan, silakan login terlebih dahulu.';
        header('Location: ../views/auth/login.php');
        exit();
    }
}
?>
