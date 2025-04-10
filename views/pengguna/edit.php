<?php
require_once('../../config/config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];  
    $username = $_POST['username'];
    $namaUser = $_POST['namaUser'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $updated_at = date('Y-m-d H:i:s');

    $query = "UPDATE users SET username = '$username', namaUser = '$namaUser', password = '$hashedPassword', role = '$role', created_at = '$updated_at' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "Data pengguna berhasil diperbarui!";
    } else {
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

