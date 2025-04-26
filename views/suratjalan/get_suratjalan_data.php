<?php
require_once('../../config/config.php');

// Memeriksa apakah parameter id ada dalam request
if (isset($_GET['id'])) {
    $idSuratJalan = $_GET['id'];

    // Query untuk mengambil data Surat Jalan berdasarkan id
    $query = "SELECT * FROM suratjalan WHERE idsuratjalan = '$idSuratJalan'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result); // Mengambil data Surat Jalan sebagai array asosiatif
        if ($data) {
            // Mengembalikan data dalam format JSON
            echo json_encode($data);
        } else {
            // Jika tidak ada data ditemukan
            echo json_encode(['error' => 'Data Surat Jalan tidak ditemukan']);
        }
    } else {
        // Jika query gagal
        echo json_encode(['error' => 'Terjadi kesalahan saat mengambil data Surat Jalan']);
    }
} else {
    // Jika parameter id tidak ditemukan
    echo json_encode(['error' => 'ID Surat Jalan tidak ditemukan']);
}
?>
