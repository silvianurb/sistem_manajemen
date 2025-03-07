<?php
require_once('../../config/config.php');

// Proses pencarian jika ada query
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data pelanggan
$query = "SELECT * FROM pelanggan WHERE nama LIKE '%$search%' OR idpelanggan LIKE '%$search%'";
$result = mysqli_query($conn, $query);

// Cek apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<h1 class="h3 mb-0 text-gray-800" style="margin-top: -10px;">Data Pelanggan</h1>

<!-- Tombol Tambah Data dan Form Pencarian Sejajar -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Tombol Tambah Data yang akan membuka modal -->
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>

    <!-- Form Pencarian -->
    <form class="d-flex w-30" id="searchForm">
        <input type="text" name="search" class="form-control" placeholder="Cari pelanggan..." value="<?php echo htmlspecialchars($search); ?>" id="searchInput">
    </form>
</div>

<!-- Tabel Pelanggan -->
<table class="table table-hover" id="resultsTable">
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

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form Tambah Data Pelanggan -->
                <form id="addPelangganForm" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="kontak" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="kontak" name="kontak" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_rekening" class="form-label">No Rekening</label>
                        <input type="text" class="form-control" id="no_rekening" name="no_rekening" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan script AJAX di bawah ini -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        // Submit form menggunakan AJAX
        $('#addPelangganForm').on('submit', function(e) {
            e.preventDefault();

            var formData = $(this).serialize();  // Mengambil data form

            $.ajax({
                url: 'tambah_data.php',  // Ganti dengan script yang menangani penyimpanan data
                method: 'POST',
                data: formData,
                success: function(response) {
                    alert('Data berhasil ditambahkan!');
                    $('#addModal').modal('hide');  // Menutup modal
                    location.reload();  // Reload halaman untuk melihat data yang baru ditambahkan
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>
