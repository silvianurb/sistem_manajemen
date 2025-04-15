<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $idOrder = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM suratjalan WHERE idsuratjalan = ?");
    $stmt->bind_param("s", $idOrder);  
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
} else {
    echo "ID Surat Jalan tidak ditemukan.";
}
