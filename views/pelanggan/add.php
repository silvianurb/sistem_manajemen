<!-- views/pelanggan/add.php -->
<?php
session_start();
include('../config/config.php');

// Cek apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../views/auth/login.php');
    exit();
}

// Proses tambah data pelanggan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $no_rekening = $_POST['no_rekening'];

    $query = "INSERT INTO pelanggan (nama, alamat, kontak, no_rekening) VALUES ('$nama', '$alamat', '$kontak', '$no_rekening')";
    if (mysqli_query($bebas, $query)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . mysqli_error($bebas);
    }
}
?>

<?php include('../header.php'); ?>

<div id="wrapper">
    <?php include('../sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <h1 class="h3 mb-0 text-gray-800">Tambah Pelanggan</h1>

            <!-- Form Tambah Pelanggan -->
            <form action="add.php" method="POST">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="no_rekening">No Rekening</label>
                    <input type="text" name="no_rekening" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Pelanggan</button>
            </form>
        </div>
    </div>
</div>

<?php include('../footer.php'); ?>
