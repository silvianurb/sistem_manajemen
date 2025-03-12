<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form edit
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $no_rekening = $_POST['no_rekening'];

    // Query untuk memperbarui data pelanggan
    $query = "UPDATE pelanggan SET nama = '$nama', alamat = '$alamat', kontak = '$kontak', no_rekening = '$no_rekening' WHERE idpelanggan = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>