<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);

    $namaBahan = $_POST['namaBahan'];
    $stok = $_POST['stok'];
    $satuan = $_POST['satuan'];

    $query = "SELECT MAX(idBahanBaku) AS max_id FROM bahanbaku";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'];
    $next_id = 'BHN' . str_pad(substr($max_id, 3) + 1, 2, '0', STR_PAD_LEFT);

    $query = "INSERT INTO bahanbaku (idBahanBaku, namaBahan, stok, satuan)
              VALUES ('$next_id', '$namaBahan', '$stok', '$satuan')";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
