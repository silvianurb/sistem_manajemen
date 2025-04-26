<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $idSuratJalan = $_POST['idSuratJalan'];
    $tanggalSuratJalan = $_POST['tanggalSuratJalan'];
    $sizeS = $_POST['sizeS'];
    $sizeM = $_POST['sizeM'];
    $sizeL = $_POST['sizeL'];
    $sizeXL = $_POST['sizeXL'];
    $sizeXXL = $_POST['sizeXXL'];
    $statusPengiriman = $_POST['statusPengiriman'];

    // Query untuk mengupdate data Surat Jalan
    $query = "UPDATE suratjalan SET 
              tanggal_surat_jalan = '$tanggalSuratJalan',
              size_s_kirim = '$sizeS',
              size_m_kirim = '$sizeM',
              size_l_kirim = '$sizeL',
              size_xl_kirim = '$sizeXL',
              size_xxl_kirim = '$sizeXXL',
              status_pengiriman = '$statusPengiriman'
              WHERE idsuratjalan = '$idSuratJalan'";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => 'Surat Jalan berhasil diperbarui']);
    } else {
        echo json_encode(['error' => 'Error saat memperbarui data Surat Jalan']);
    }
}
?>
