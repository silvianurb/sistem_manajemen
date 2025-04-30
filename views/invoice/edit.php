<?php
require_once('../../config/config.php');

// Ambil data dari form
$idInvoice = $_POST['idInvoice'];
$tanggalInvoice = $_POST['tanggalInvoice'];
$idSuratJalan = $_POST['idSuratJalan'];
$sizeS = $_POST['sizeS'];
$sizeM = $_POST['sizeM'];
$sizeL = $_POST['sizeL'];
$sizeXL = $_POST['sizeXL'];
$sizeXXL = $_POST['sizeXXL'];
$hargaS = $_POST['hargaS'];
$hargaM = $_POST['hargaM'];
$hargaL = $_POST['hargaL'];
$hargaXL = $_POST['hargaXL'];
$hargaXXL = $_POST['hargaXXL'];

// Total bayarnya
$totalS = $sizeS * $hargaS;
$totalM = $sizeM * $hargaM;
$totalL = $sizeL * $hargaL;
$totalXL = $sizeXL * $hargaXL;
$totalXXL = $sizeXXL * $hargaXXL;

$totalBayar = $totalS + $totalM + $totalL + $totalXL + $totalXXL;

// Query untuk update data
$query = "UPDATE invoice 
          SET tanggal_invoice = '$tanggalInvoice', idSuratJalan = '$idSuratJalan', 
              total_bayar = '$totalBayar', size_s = '$sizeS', size_m = '$sizeM', size_l = '$sizeL',
              size_xl = '$sizeXL', size_xxl = '$sizeXXL', harga_s = '$hargaS', harga_m = '$hargaM',
              harga_l = '$hargaL', harga_xl = '$hargaXL', harga_xxl = '$hargaXXL',
              total_s = '$totalS', total_m = '$totalM', total_l = '$totalL', total_xl = '$totalXL', 
              total_xxl = '$totalXXL'
          WHERE idInvoice = '$idInvoice'";

$result = mysqli_query($conn, $query);

if ($result) {
    echo "success";
} else {
    echo "error: " . mysqli_error($conn); 
}
?>
