<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $idOrder = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM pesanan WHERE idOrder = ?");
    $stmt->bind_param("s", $idOrder);  
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
} else {
    echo "ID order tidak ditemukan.";
}
