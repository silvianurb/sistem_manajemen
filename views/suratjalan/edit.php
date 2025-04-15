<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $idSuratJalan = $_POST['idSuratJalan'];
    $idOrder = $_POST['idOrder'];
    $tanggalSuratJalan = $_POST['tanggalSuratJalan'];
    $namaPelanggan = $_POST['namaPelanggan'];
    $namaBarang = $_POST['namaBarang'];
    $alamatPelanggan = $_POST['alamatPelanggan'];
    $sizeS = $_POST['sizeS'];
    $sizeM = $_POST['sizeM'];
    $sizeL = $_POST['sizeL'];
    $sizeXL = $_POST['sizeXL'];
    $sizeXXL = $_POST['sizeXXL'];
    $status = $_POST['status'];

    // Query untuk memperbarui data Surat Jalan
    $query = "UPDATE suratjalan 
              SET idOrder = '$idOrder',
                  tanggalSuratJalan = '$tanggalSuratJalan',
                  namaPelanggan = '$namaPelanggan',
                  namaBarang = '$namaBarang',
                  alamatPelanggan = '$alamatPelanggan',
                  sizeS = '$sizeS',
                  sizeM = '$sizeM',
                  sizeL = '$sizeL',
                  sizeXL = '$sizeXL',
                  sizeXXL = '$sizeXXL',
                  status = '$status'
              WHERE idSuratJalan = '$idSuratJalan'";

    if (mysqli_query($conn, $query)) {
        // Update sisa kirim pada tabel pesanan
        $queryUpdate = "UPDATE pesanan 
                        SET sizeS = sizeS - $sizeS, 
                            sizeM = sizeM - $sizeM, 
                            sizeL = sizeL - $sizeL, 
                            sizeXL = sizeXL - $sizeXL, 
                            sizeXXL = sizeXXL - $sizeXXL
                        WHERE idOrder = '$idOrder'";

        if (mysqli_query($conn, $queryUpdate)) {
            echo json_encode(['success' => 'Surat Jalan berhasil diperbarui dan pesanan diperbarui']);
        } else {
            echo json_encode(['error' => 'Error saat memperbarui data pesanan']);
        }
    } else {
        echo json_encode(['error' => 'Error saat memperbarui data Surat Jalan']);
    }
}
?>
