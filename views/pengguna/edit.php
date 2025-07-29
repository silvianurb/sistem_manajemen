<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];  
    $username = $_POST['username'];
    $namaUser = $_POST['namaUser'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    // Jika password tidak kosong, hash password dan update
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET username = '$username', namaUser = '$namaUser', password = '$hashedPassword', role = '$role' WHERE id = '$id'";
    } else {
        // Jika password kosong, hanya update selain password
        $query = "UPDATE users SET username = '$username', namaUser = '$namaUser', role = '$role' WHERE id = '$id'";
    }

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "Data pengguna berhasil diperbarui!";
    } else {
        // Jika gagal, tampilkan error dengan pesan yang lebih spesifik
        echo "Error: " . mysqli_error($conn);
    }
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if (!$user) {
            echo "Pengguna tidak ditemukan.";
            exit;
        }
    } else {
        echo "ID pengguna tidak ditemukan.";
        exit;
    }
}
?>
