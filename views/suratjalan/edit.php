<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form edit yang dikirimkan menggunakan AJAX
    $idSuratJalan = $_POST['idSuratJalan'];
    $tanggalSuratJalan = $_POST['tanggalSuratJalan'];
    $sizeS = $_POST['sizeS'];
    $sizeM = $_POST['sizeM'];
    $sizeL = $_POST['sizeL'];
    $sizeXL = $_POST['sizeXL'];
    $sizeXXL = $_POST['sizeXXL'];
    $statusPengiriman = $_POST['statusPengiriman'];

    // Ambil data sebelumnya dari suratjalan untuk membandingkan perubahan size
    $queryOld = "SELECT * FROM suratjalan WHERE idsuratjalan = '$idSuratJalan'";
    $resultOld = mysqli_query($conn, $queryOld);
    $oldData = mysqli_fetch_assoc($resultOld);

    // Hitung selisih size
    $SizeS = $sizeS - $oldData['size_s_kirim'];
    $SizeM = $sizeM - $oldData['size_m_kirim'];
    $SizeL = $sizeL - $oldData['size_l_kirim'];
    $SizeXL = $sizeXL - $oldData['size_xl_kirim'];
    $SizeXXL = $sizeXXL - $oldData['size_xxl_kirim'];

    // Query untuk memperbarui data Surat Jalan di database
    $query = "UPDATE suratjalan 
              SET tanggal_surat_jalan = '$tanggalSuratJalan', 
                  size_s_kirim = '$sizeS', 
                  size_m_kirim = '$sizeM', 
                  size_l_kirim = '$sizeL', 
                  size_xl_kirim = '$sizeXL', 
                  size_xxl_kirim = '$sizeXXL', 
                  status_pengiriman = '$statusPengiriman' 
              WHERE idsuratjalan = '$idSuratJalan'";

    // Menjalankan query update untuk surat jalan
    if (mysqli_query($conn, $query)) {
        // Setelah update Surat Jalan, update data pesanan berdasarkan selisih size
        $queryUpdatePesanan = "UPDATE pesanan SET 
            sizeS = sizeS - $SizeS, 
            sizeM = sizeM - $SizeM, 
            sizeL = sizeL - $SizeL, 
            sizeXL = sizeXL - $SizeXL, 
            sizeXXL = sizeXXL - $SizeXXL,
            sisaKirim = sisaKirim - ($SizeS + $SizeM + $SizeL + $SizeXL + $SizeXXL)
            WHERE idOrder = (SELECT idOrder FROM suratjalan WHERE idsuratjalan = '$idSuratJalan')";

        if (mysqli_query($conn, $queryUpdatePesanan)) {
            echo json_encode(['success' => 'Data Surat Jalan berhasil diperbarui dan pesanan diperbarui']);
        } else {
            echo json_encode(['error' => 'Error saat memperbarui data pesanan']);
        }
    } else {
        echo json_encode(['error' => 'Gagal memperbarui data Surat Jalan']);
    }
}
?>
