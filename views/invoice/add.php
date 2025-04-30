<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $idInvoice = $_POST['idInvoice']; 
    $tanggalInvoice = $_POST['tanggalInvoice']; 
    $idSuratJalan = $_POST['idSuratJalan'];  
    $namaPelanggan = $_POST['namaPelanggan'];  
    $namaBarang = $_POST['namaBarang'];  
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

    // Hitung total harga per size
    $totalS = $sizeS * $hargaS;
    $totalM = $sizeM * $hargaM;
    $totalL = $sizeL * $hargaL;
    $totalXL = $sizeXL * $hargaXL;
    $totalXXL = $sizeXXL * $hargaXXL;

    // Hitung total bayar
    $totalBayar = $totalS + $totalM + $totalL + $totalXL + $totalXXL;

    // Query untuk insert data ke tabel invoice
    $query = "INSERT INTO invoice (idInvoice, tanggal_invoice, idSuratJalan, nama_pelanggan, nama_barang, 
                                    size_s, size_m, size_l, size_xl, size_xxl, 
                                    harga_s, harga_m, harga_l, harga_xl, harga_xxl,
                                    total_s, total_m, total_l, total_xl, total_xxl, total_bayar) 
              VALUES ('$idInvoice', '$tanggalInvoice', '$idSuratJalan', '$namaPelanggan', '$namaBarang', 
                      '$sizeS', '$sizeM', '$sizeL', '$sizeXL', '$sizeXXL', 
                      '$hargaS', '$hargaM', '$hargaL', '$hargaXL', '$hargaXXL',
                      '$totalS', '$totalM', '$totalL', '$totalXL', '$totalXXL', '$totalBayar')";

    if (mysqli_query($conn, $query)) {
        echo "success";  
    } else {
        echo "error: " . mysqli_error($conn); 
    }
} else {
    echo "error: Invalid request.";  
}
?>
