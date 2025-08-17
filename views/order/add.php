<?php
require_once('../../config/config.php');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $namaPelanggan = $_POST['namaPelanggan'];
    $tanggalPesanan = $_POST['tanggalPesanan'];
    $namaBarang = $_POST['namaBarang'];
    $sizeS = (int)$_POST['sizeS'];
    $sizeM = (int)$_POST['sizeM'];
    $sizeL = (int)$_POST['sizeL'];
    $sizeXL = (int)$_POST['sizeXL'];
    $sizeXXL = (int)$_POST['sizeXXL'];
    $bahan = $_POST['bahan'];
    $sisaKirim = (int)$_POST['sisaKirim'];
    $status = $_POST['status'];

    if ($sizeS < 0 || $sizeM < 0 || $sizeL < 0 || $sizeXL < 0 || $sizeXXL < 0) {
        $response['message'] = "Error: Jumlah ukuran tidak boleh negatif.";
    } elseif ($sisaKirim != ($sizeS + $sizeM + $sizeL + $sizeXL + $sizeXXL)) {
        $response['message'] = "Error: Total sisa kirim tidak sesuai jumlah ukuran.";
    } elseif (empty($namaPelanggan) || empty($namaBarang)) {
        $response['message'] = "Error: Nama pelanggan dan nama barang harus diisi.";
    } elseif (!in_array($status, ['Pending', 'Diproses', 'Dikirim', 'Selesai'])) {
        $response['message'] = "Error: Status tidak valid.";
    } else {

        // Semua rule valid, lanjut generate ID order
        $query = "SELECT MAX(idOrder) AS max_id FROM pesanan";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'];

        if ($max_id === NULL) {
            $next_id = 'ORD01';
        } else {
            $next_id = 'ORD' . str_pad((substr($max_id, 3) + 1), 2, '0', STR_PAD_LEFT);
        }

        // Insert data
        $query = "INSERT INTO pesanan (idOrder, namaPelanggan, tanggalPesanan, namaBarang, sizeS, sizeM, sizeL, sizeXL, sizeXXL, bahan, sisaKirim, status)
                  VALUES ('$next_id', '$namaPelanggan', NOW(), '$namaBarang', '$sizeS', '$sizeM', '$sizeL', '$sizeXL', '$sizeXXL', '$bahan', '$sisaKirim', '$status')";

        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Order berhasil ditambahkan!";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
    }

    // Kembalikan response ke Ajax
    echo json_encode($response);
}
?>
