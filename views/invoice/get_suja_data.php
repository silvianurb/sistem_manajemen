<?php
require_once('../../config/config.php');

if (isset($_GET['idSuratJalan'])) {
    $idSuratJalan = $_GET['idSuratJalan'];

    // Query untuk mengambil data berdasarkan ID Surat Jalan
    $query = "SELECT * FROM suratjalan WHERE idsuratjalan = '$idSuratJalan'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['error' => 'Gagal mengambil data.']);
        exit();
    }

    // Ambil data jika ada
    $data = mysqli_fetch_assoc($result);

    if ($data) {
        echo json_encode([
            'namaPelanggan' => $data['nama_pelanggan'],
            'namaBarang' => $data['nama_barang'],
            'sizeS' => $data['size_s_kirim'],
            'sizeM' => $data['size_m_kirim'],
            'sizeL' => $data['size_l_kirim'],
            'sizeXL' => $data['size_xl_kirim'],
            'sizeXXL' => $data['size_xxl_kirim']
        ]);
    } else {
        echo json_encode(['error' => 'Data tidak ditemukan.']);
    }
}
?>
