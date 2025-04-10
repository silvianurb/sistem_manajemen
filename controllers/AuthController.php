<?php
session_start();
include_once('../config/config.php'); // Menghubungkan dengan file config.php yang berisi pengaturan database

// Cek apakah form sudah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data username dan password dari form
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Query untuk mencari user berdasarkan username
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    // Cek apakah user ditemukan
    if ($user) {
        // Verifikasi password menggunakan password_verify()
        if (password_verify($password, $user['password'])) {
            // Password benar, buat session untuk user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect ke halaman dashboard setelah login berhasil
            header('Location: ../views/dashboard.php');
            exit();
        } else {
            // Password salah, simpan pesan error ke session
            $_SESSION['error_message'] = 'Password yang Anda masukkan salah. Silakan coba lagi.';
            header('Location: ../views/auth/login.php');
            exit();
        }
    } else {
        // Username tidak ditemukan, simpan pesan error ke session
        $_SESSION['error_message'] = 'Username tidak ditemukan!';
        header('Location: ../views/auth/login.php');
        exit();
    }
} else {
    // Jika bukan metode POST, arahkan kembali ke halaman login
    header('Location: ../views/auth/login.php');
    exit();
}
?>
