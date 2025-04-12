<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namaPelanggan = $_POST['namaPelanggan'];
    $tanggalPesanan = $_POST['tanggalPesanan'];
    $namaBarang = $_POST['namaBarang'];
    $sizeS = $_POST['sizeS'];
    $sizeM = $_POST['sizeM'];
    $sizeL = $_POST['sizeL'];
    $sizeXL = $_POST['sizeXL'];
    $sizeXXL = $_POST['sizeXXL'];
    $bahan = $_POST['bahan'];
    $sisaKirim = $_POST['sisaKirim'];
    $status = $_POST['status'];

    $query = "SELECT MAX(idOrder) AS max_id FROM pesanan";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];

    // Membuat ID baru dengan format ORD01, ORD02, dst
    $next_id = 'ORD' . str_pad((substr($max_id, 3) + 1), 2, '0', STR_PAD_LEFT); 

    // Query untuk menambahkan data pesanan
    $query = "INSERT INTO pesanan (idOrder, namaPelanggan, tanggalPesanan, namaBarang, sizeS, sizeM, sizeL, sizeXL, sizeXXL, bahan, sisaKirim, status)
          VALUES ('$next_id', '$namaPelanggan', NOW(), '$namaBarang', '$sizeS', '$sizeM', '$sizeL', '$sizeXL', '$sizeXXL', '$bahan', '$sisaKirim', '$status')";

    if (mysqli_query($conn, $query)) {
        echo "Order berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
