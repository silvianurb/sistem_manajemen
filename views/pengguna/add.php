<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $namaUser = $_POST['namaUser'];
    $password = $_POST['password']; 
    $role = $_POST['role'];

     // Hash password sebelum disimpan, memotong hasil hash
     $hashedPassword = substr(password_hash($password, PASSWORD_DEFAULT), 0, 30); // Mengambil 30 karakter pertama dari hash

    $created_at = date('Y-m-d H:i:s');

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

    $query = "INSERT INTO users (id, username, namaUser, password, role, created_at)
              VALUES ('$next_id', '$username', '$namaUser', '$hashedPassword', '$role', '$created_at')";

    if (mysqli_query($conn, $query)) {
        echo "Data pengguna berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
