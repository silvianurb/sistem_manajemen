<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idBahanBaku = $_POST['idBahanBaku'];
    $namaBahan = $_POST['namaBahan'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    $query = "UPDATE bahanbaku SET namaBahan = '$namaBahan', stok = '$stok', satuan = '$satuan' WHERE idBahanBaku = '$idBahanBaku'";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
