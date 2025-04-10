<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $idBahanBaku = $_GET['id'];

    $query = "DELETE FROM bahanbaku WHERE idBahanBaku = '$idBahanBaku'";

    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "ID bahan baku tidak ditemukan.";
}
?>
