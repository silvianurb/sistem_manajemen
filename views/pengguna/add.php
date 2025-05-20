<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $namaUser = $_POST['namaUser'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    // Hash password sebelum disimpan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $created_at = date('Y-m-d H:i:s');

    // Periksa apakah ada pengguna terlebih dahulu untuk mendapatkan ID yang benar
    $query = "SELECT COUNT(*) AS total_users FROM users";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Jika tidak ada pengguna, buat ID pertama
    if ($row['total_users'] == 0) {
        $next_id = 'USR01';
    } else {
        $query = "SELECT MAX(id) AS max_id FROM users";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'];
        $next_id = 'USR' . str_pad((substr($max_id, 3) + 1), 2, '0', STR_PAD_LEFT);
    }

    // Query untuk menambahkan pengguna baru
    $query = "INSERT INTO users (id, username, namaUser, password, role, created_at)
              VALUES ('$next_id', '$username', '$namaUser', '$hashedPassword', '$role', '$created_at')";

    // Debugging - Tampilkan query yang dijalankan
    echo "Query yang dijalankan: " . $query . "<br>";

    if (mysqli_query($conn, $query)) {
        echo "Data pengguna berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn); // Tampilkan error jika ada
    }
}
?>
