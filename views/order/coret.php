<?php
// Validasi jumlah ukuran tidak boleh negatif
if ($sizeS < 0 || $sizeM < 0 || $sizeL < 0 || $sizeXL < 0 || $sizeXXL < 0) { 
    $response['message'] = "Error: Jumlah ukuran tidak boleh negatif."; 
} elseif ($sisaKirim != ($sizeS + $sizeM + $sizeL + $sizeXL + $sizeXXL)) {  
    $response['message'] = "Error: Total sisa kirim tidak sesuai jumlah ukuran.";
} elseif (empty($namaPelanggan) || empty($namaBarang)) {
    $response['message'] = "Error: Nama pelanggan dan nama barang harus diisi.";
} elseif (!in_array($status, ['Pending', 'Diproses', 'Dikirim', 'Selesai'])) {
    $response['message'] = "Error: Status tidak valid.";
} else {
    if ($max_id === NULL) {
        $next_id = 'ORD01';
    } else {
        $next_id = 'ORD' . str_pad((substr($max_id, 3) + 1), 2, '0', STR_PAD_LEFT);
    }
}

// Ambil data pesanan saat ini
$queryPesanan = "SELECT * FROM pesanan WHERE idOrder='$idOrder'";
$resultPesanan = mysqli_query($conn, $queryPesanan);
$dataPesanan = mysqli_fetch_assoc($resultPesanan);

if ($sizeS < 0 || $sizeM < 0 || $sizeL < 0 || $sizeXL < 0 || $sizeXXL < 0) {
    $response['message'] = "Error: Jumlah pengiriman tidak boleh negatif.";
} elseif ($sizeS > $dataPesanan['sizeS'] || $sizeM > $dataPesanan['sizeM'] || 
          $sizeL > $dataPesanan['sizeL'] || $sizeXL > $dataPesanan['sizeXL'] || 
          $sizeXXL > $dataPesanan['sizeXXL']) {
    $response['message'] = "Error: Jumlah pengiriman melebihi sisa pesanan.";
} elseif (empty($namaPelanggan) || empty($namaBarang) || empty($alamatPelanggan)) {
    $response['message'] = "Error: Nama pelanggan, nama barang, dan alamat harus diisi.";
} else {
}


// Cek kesesuaian dengan Surat Jalan
$querySJ = "SELECT * FROM suratjalan WHERE idsuratjalan='$idSuratJalan'";
$resultSJ = mysqli_query($conn, $querySJ);

if(mysqli_num_rows($resultSJ) == 0) {
    echo json_encode(['error' => 'ID Surat Jalan tidak ditemukan']);
    exit; // RULE
}
$dataSJ = mysqli_fetch_assoc($resultSJ);
if($namaPelanggan != $dataSJ['nama_pelanggan']) {
    echo json_encode(['error' => 'Nama pelanggan tidak sesuai dengan Surat Jalan']);
    exit;
}
if($namaBarang != $dataSJ['nama_barang']) {
    echo json_encode(['error' => 'Nama barang tidak sesuai dengan Surat Jalan']);
    exit;
}


?>