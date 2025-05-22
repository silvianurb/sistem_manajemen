<?php
session_start();
include_once('../config/config.php'); 

// Cek apakah form sudah disubmit dengan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        echo "Password yang dimasukkan: " . $password . "<br>";
        echo "Hash password yang disimpan: " . $user['password'] . "<br>";

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['namaUser'] = $user['namaUser'];
            $_SESSION['role'] = $user['role'];

            header('Location: ../views/dashboard.php');
            exit();
        } else {
            $_SESSION['error_message'] = 'Password yang Anda masukkan salah. Silakan coba lagi.';
            header('Location: ../views/auth/login.php');
            exit();
        }
    } else {
        $_SESSION['error_message'] = 'Username tidak ditemukan!';
        header('Location: ../views/auth/login.php');
        exit();
    }
} else {
    header('Location: ../views/auth/login.php');
    exit();
}
?>