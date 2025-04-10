<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM users WHERE id = '$id'"; 

    if (mysqli_query($conn, $query)) {
        echo "success"; 
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "ID pengguna tidak ditemukan.";
}
?>
