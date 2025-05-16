<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idOrder = $_POST['idOrder'];
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

    // Update the order in the database
    $query = "UPDATE pesanan 
              SET namaPelanggan = '$namaPelanggan', 
                  tanggalPesanan = '$tanggalPesanan', 
                  namaBarang = '$namaBarang', 
                  sizeS = '$sizeS', 
                  sizeM = '$sizeM', 
                  sizeL = '$sizeL', 
                  sizeXL = '$sizeXL', 
                  sizeXXL = '$sizeXXL', 
                  bahan = '$bahan', 
                  sisaKirim = '$sisaKirim', 
                  status = '$status' 
              WHERE idOrder = '$idOrder'";

    if (mysqli_query($conn, $query)) {
        echo "Data pesanan berhasil diperbarui!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>