<?php
require_once('../../config/config.php');

if (isset($_GET['idOrder'])) {
    $idOrder = $_GET['idOrder'];
    
    $query = "SELECT pesanan.idOrder, pesanan.namaPelanggan, pesanan.namaBarang
              FROM pesanan
              WHERE pesanan.idOrder = '$idOrder'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID Order tidak diberikan']);
}
?>
