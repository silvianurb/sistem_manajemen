<?php
require_once('../../config/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Tampilkan data yang diterima
    var_dump($_POST);  // Ini akan menampilkan semua data yang diterima dari form

    // Ambil data dari form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $no_rekening = $_POST['no_rekening'];

    // Generate ID Pelanggan berikutnya
    $query = "SELECT MAX(idpelanggan) AS max_id FROM pelanggan";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Cek apakah max_id kosong
    if ($row['max_id'] === NULL) {
        // Jika tidak ada data di database, set ID pertama menjadi PEL01
        $next_id = 'PEL01';
    } else {
        // Jika ada data, generate ID berikutnya
        $max_id = $row['max_id'];
        $next_id = 'PEL' . str_pad(substr($max_id, 3) + 1, 2, '0', STR_PAD_LEFT);
    }

    // Simpan data ke database
    $query = "INSERT INTO pelanggan (idpelanggan, nama, alamat, kontak, no_rekening)
              VALUES ('$next_id', '$nama', '$alamat', '$kontak', '$no_rekening')";

    if (mysqli_query($conn, $query)) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
