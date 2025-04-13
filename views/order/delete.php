<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $idOrder = $_GET['id'];

    $query = "DELETE FROM pesanan WHERE idOrder = '$idOrder'";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "ID bahan baku tidak ditemukan.";
}
?>
