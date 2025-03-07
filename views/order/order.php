<?php
require_once('../../config/config.php');

$query = "SELECT * FROM pelanggan";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<h1 class="h3 mb-0 text-gray-800">Data Order</h1>

<!-- Tabel Pelanggan -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID Pelanggan</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th>No Rekening</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['idpelanggan']; ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['kontak']; ?></td>
            <td><?php echo $row['no_rekening']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['idpelanggan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?php echo $row['idpelanggan']; ?>" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php
// Tutup koneksi database jika sudah selesai
mysqli_close($conn);
?>
