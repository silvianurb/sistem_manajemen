<?php
require_once('../../config/config.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $idOrder = $_POST['idOrder'];
    $tanggalSuratJalan = $_POST['tanggalSuratJalan'];
    $namaPelanggan = $_POST['namaPelanggan'];
    $namaBarang = $_POST['namaBarang'];
    $alamatPelanggan = $_POST['alamatPelanggan'];

    // Set size default 0 jika kosong
    $sizeS = isset($_POST['sizeS']) && !empty($_POST['sizeS']) ? (int)$_POST['sizeS'] : 0;
    $sizeM = isset($_POST['sizeM']) && !empty($_POST['sizeM']) ? (int)$_POST['sizeM'] : 0;
    $sizeL = isset($_POST['sizeL']) && !empty($_POST['sizeL']) ? (int)$_POST['sizeL'] : 0;
    $sizeXL = isset($_POST['sizeXL']) && !empty($_POST['sizeXL']) ? (int)$_POST['sizeXL'] : 0;
    $sizeXXL = isset($_POST['sizeXXL']) && !empty($_POST['sizeXXL']) ? (int)$_POST['sizeXXL'] : 0;

    $status = $_POST['statusPengiriman'];

    // ===========================
    // RULE-BASED VALIDATION (FORWARD CHAINING)
    // ===========================

    // Ambil data pesanan saat ini
    $queryPesanan = "SELECT * FROM pesanan WHERE idOrder='$idOrder'";
    $resultPesanan = mysqli_query($conn, $queryPesanan);
    if (!$resultPesanan || mysqli_num_rows($resultPesanan) == 0) {
        $response['message'] = "Error: Pesanan tidak ditemukan.";
        echo json_encode($response);
        exit;
    }
    $dataPesanan = mysqli_fetch_assoc($resultPesanan);

    // IF–THEN rules
    if ($sizeS < 0 || $sizeM < 0 || $sizeL < 0 || $sizeXL < 0 || $sizeXXL < 0) {
        $response['message'] = "Error: Jumlah pengiriman tidak boleh negatif.";
    } elseif ($sizeS > $dataPesanan['sizeS'] || $sizeM > $dataPesanan['sizeM'] || 
              $sizeL > $dataPesanan['sizeL'] || $sizeXL > $dataPesanan['sizeXL'] || 
              $sizeXXL > $dataPesanan['sizeXXL']) {
        $response['message'] = "Error: Jumlah pengiriman melebihi sisa pesanan.";
    } elseif (empty($namaPelanggan) || empty($namaBarang) || empty($alamatPelanggan)) {
        $response['message'] = "Error: Nama pelanggan, nama barang, dan alamat harus diisi.";
    } else {
        // Semua rule valid, lanjut buat ID Surat Jalan
        $query = "SELECT MAX(CAST(SUBSTRING(idsuratjalan, 3) AS UNSIGNED)) AS max_id FROM suratjalan";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'] + 1;
        $idSuratJalan = 'SJ' . str_pad($max_id, 2, '0', STR_PAD_LEFT);

        // Insert Surat Jalan
        $queryInsert = "INSERT INTO suratjalan (idsuratjalan, idOrder, tanggal_surat_jalan, nama_pelanggan, nama_barang, alamat_pelanggan, 
                        size_s_kirim, size_m_kirim, size_l_kirim, size_xl_kirim, size_xxl_kirim, status_pengiriman) 
                        VALUES ('$idSuratJalan', '$idOrder', '$tanggalSuratJalan', '$namaPelanggan', '$namaBarang', '$alamatPelanggan', 
                        '$sizeS', '$sizeM', '$sizeL', '$sizeXL', '$sizeXXL', '$status')";

        if (mysqli_query($conn, $queryInsert)) {
            // Update data pesanan
            $queryUpdate = "UPDATE pesanan SET 
                sizeS = sizeS - $sizeS, 
                sizeM = sizeM - $sizeM, 
                sizeL = sizeL - $sizeL, 
                sizeXL = sizeXL - $sizeXL, 
                sizeXXL = sizeXXL - $sizeXXL,
                sisaKirim = sisaKirim - ($sizeS + $sizeM + $sizeL + $sizeXL + $sizeXXL)
                WHERE idOrder = '$idOrder'";

            if (mysqli_query($conn, $queryUpdate)) {
                $response['success'] = true;
                $response['message'] = "Surat Jalan berhasil dibuat dan pesanan diperbarui.";
            } else {
                $response['message'] = "Error saat memperbarui data pesanan.";
            }
        } else {
            $response['message'] = "Error saat menyimpan data Surat Jalan.";
        }
    }

    echo json_encode($response);
}
?>
