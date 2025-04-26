<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $idOrder = $_POST['idOrder'];
    $tanggalSuratJalan = $_POST['tanggalSuratJalan'];
    $namaPelanggan = $_POST['namaPelanggan'];
    $namaBarang = $_POST['namaBarang'];
    $alamatPelanggan = $_POST['alamatPelanggan'];
    
    // Cek apakah sizeS, sizeM, sizeL, sizeXL, sizeXXL kosong, jika kosong set ke 0
    $sizeS = isset($_POST['sizeS']) && !empty($_POST['sizeS']) ? $_POST['sizeS'] : 0;
    $sizeM = isset($_POST['sizeM']) && !empty($_POST['sizeM']) ? $_POST['sizeM'] : 0;
    $sizeL = isset($_POST['sizeL']) && !empty($_POST['sizeL']) ? $_POST['sizeL'] : 0;
    $sizeXL = isset($_POST['sizeXL']) && !empty($_POST['sizeXL']) ? $_POST['sizeXL'] : 0;
    $sizeXXL = isset($_POST['sizeXXL']) && !empty($_POST['sizeXXL']) ? $_POST['sizeXXL'] : 0;

    $status = $_POST['statusPengiriman'];

    // Generate ID Surat Jalan otomatis (misal: SJ01, SJ02, dst)
    $query = "SELECT MAX(CAST(SUBSTRING(idsuratjalan, 3) AS UNSIGNED)) AS max_id FROM suratjalan";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'] + 1;
    $idSuratJalan = 'SJ' . str_pad($max_id, 2, '0', STR_PAD_LEFT);

    // Query untuk menyimpan data Surat Jalan
    $query = "INSERT INTO suratjalan (idsuratjalan, idOrder, tanggal_surat_jalan, nama_pelanggan, nama_barang, alamat_pelanggan, 
                                      size_s_kirim, size_m_kirim, size_l_kirim, size_xl_kirim, size_xxl_kirim, status_pengiriman) 
              VALUES ('$idSuratJalan', '$idOrder', '$tanggalSuratJalan', '$namaPelanggan', '$namaBarang', '$alamatPelanggan', 
                      '$sizeS', '$sizeM', '$sizeL', '$sizeXL', '$sizeXXL', '$status')";

    if (mysqli_query($conn, $query)) {
        // Setelah insert, update data pesanan
        $queryUpdate = "UPDATE pesanan SET 
            sizeS = sizeS - $sizeS, 
            sizeM = sizeM - $sizeM, 
            sizeL = sizeL - $sizeL, 
            sizeXL = sizeXL - $sizeXL, 
            sizeXXL = sizeXXL - $sizeXXL,
            sisaKirim = sisaKirim - ($sizeS + $sizeM + $sizeL + $sizeXL + $sizeXXL)
            WHERE idOrder = '$idOrder'";

        if (mysqli_query($conn, $queryUpdate)) {
            echo json_encode(['success' => 'Surat Jalan berhasil dibuat dan pesanan diperbarui']);
        } else {
            echo json_encode(['error' => 'Error saat memperbarui data pesanan']);
        }
    } else {
        echo json_encode(['error' => 'Error saat menyimpan data Surat Jalan']);
    }
}
?>
