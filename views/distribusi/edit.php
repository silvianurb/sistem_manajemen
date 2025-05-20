<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form edit yang dikirimkan menggunakan AJAX
    $idSuratJalan = $_POST['idSuratJalan'];
    $statusPengiriman = $_POST['statusPengiriman'];

    // Query untuk mengambil data lama dari suratjalan untuk keperluan pengecekan status sebelumnya (opsional)
    $queryOld = "SELECT * FROM suratjalan WHERE idsuratjalan = '$idSuratJalan'";
    $resultOld = mysqli_query($conn, $queryOld);
    $oldData = mysqli_fetch_assoc($resultOld);

    // Query untuk memperbarui data Surat Jalan di database
    $query = "UPDATE suratjalan 
              SET status_pengiriman = '$statusPengiriman'
              WHERE idsuratjalan = '$idSuratJalan'";

    // Menjalankan query update untuk surat jalan
    if (mysqli_query($conn, $query)) {
        // Setelah update Surat Jalan, kita bisa memeriksa apakah perlu update data pesanan (opsional)
        // Tidak perlu menghitung selisih ukuran karena hanya status pengiriman yang berubah
        echo json_encode(['success' => 'Data Surat Jalan berhasil diperbarui']);
    } else {
        echo json_encode(['error' => 'Gagal memperbarui data Surat Jalan']);
    }
}
?>
