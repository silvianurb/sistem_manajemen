<!-- views/pelanggan/edit.php -->
<?php
session_start();
include('../config/config.php');

// Cek apakah pengguna sudah login dan memiliki role admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../views/auth/login.php');
    exit();
}

// Ambil data pelanggan berdasarkan ID
$id = $_GET['id'];
$query = "SELECT * FROM pelanggan WHERE idpelanggan = '$id'";
$result = mysqli_query($bebas, $query);
$row = mysqli_fetch_assoc($result);

// Proses update data pelanggan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kontak = $_POST['kontak'];
    $no_rekening = $_POST['no_rekening'];

    $query = "UPDATE pelanggan SET nama = '$nama', alamat = '$alamat', kontak = '$kontak', no_rekening = '$no_rekening' WHERE idpelanggan = '$id'";
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
            <h1 class="h3 mb-0 text-gray-800">Edit Pelanggan</h1>

            <!-- Form Edit Pelanggan -->
            <form action="edit.php?id=<?php echo $id; ?>" method="POST">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?php echo $row['nama']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" required><?php echo $row['alamat']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="kontak">Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="<?php echo $row['kontak']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="no_rekening">No Rekening</label>
                    <input type="text" name="no_rekening" class="form-control" value="<?php echo $row['no_rekening']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Pelanggan</button>
            </form>
        </div>
    </div>
</div>

<?php include('../footer.php'); ?>
