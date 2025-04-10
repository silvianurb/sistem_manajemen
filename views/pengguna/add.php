<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $namaUser = $_POST['namaUser'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

    // Hash password sebelum disimpan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Set waktu created_at otomatis menggunakan timestamp
    $created_at = date('Y-m-d H:i:s');

    // Cek apakah ada data pengguna di tabel
    $query = "SELECT COUNT(*) AS total_users FROM users";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Jika tidak ada pengguna, buat ID pertama
    if ($row['total_users'] == 0) {
        $next_id = 'USR01';  // ID pertama
    } else {
        // Jika ada data, ambil ID terakhir dan tambahkan 1
        $query = "SELECT MAX(id) AS max_id FROM users";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        // Ambil angka ID dan tambahkan 1
        $max_id = $row['max_id'];
        $next_id = 'USR' . str_pad((substr($max_id, 3) + 1), 2, '0', STR_PAD_LEFT);
    }

    // Query untuk memasukkan data pengguna
    $query = "INSERT INTO users (id, username, namaUser, password, role, created_at)
              VALUES ('$next_id', '$username', '$namaUser', '$hashedPassword', '$role', '$created_at')";

    if (mysqli_query($conn, $query)) {
        echo "Data pengguna berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
