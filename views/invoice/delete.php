<?php
require_once('../../config/config.php');

// Cek apakah ID invoice diterima melalui parameter GET
if (isset($_GET['idInvoice'])) {
    $idInvoice = $_GET['idInvoice'];
    $query = "DELETE FROM invoice WHERE idInvoice = '$idInvoice'";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        echo "success";
    } else {
        echo "error: " . mysqli_error($conn);
    }
} else {
    echo "error: ID Invoice tidak ditemukan.";
}
?>
