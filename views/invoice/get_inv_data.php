<?php
require_once('../../config/config.php');

$idInvoice = $_GET['idInvoice'] ?? '';
if (empty($idInvoice)) {
    echo json_encode(['error' => 'ID Invoice tidak ditemukan']);
    exit;
}

$query = "SELECT idInvoice, tanggal_invoice, idSuratJalan, nama_pelanggan, nama_barang,  
                 size_s, size_m, size_l, size_xl, size_xxl, harga_s, harga_m, harga_l, harga_xl, harga_xxl, 
                 total_s, total_m, total_l, total_xl, total_xxl, total_bayar
          FROM invoice 
          WHERE idInvoice = '$idInvoice'";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => 'Query gagal: ' . mysqli_error($conn)]);
    exit;
}

$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo json_encode(['error' => 'Data tidak ditemukan']);
    exit;
}

echo json_encode($data);
?>
