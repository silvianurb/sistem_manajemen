    <?php
    session_start();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <link href="../assets/styles.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <?php
        require_once('../../config/config.php');
        // Query untuk mengambil data pelanggan
        $query = "SELECT * FROM pelanggan";
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query gagal: " . mysqli_error($conn));
        }
        ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Data Pelanggan</h6>
            </div>
            <div class="card-body">
                <!-- Tambah Data Button placed here -->
                <div class="mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Data</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                </div>
            </div>
        </div>

        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Data Pelanggan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
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

        <!-- Pesan sukses muncul disini setelah berhasil menambah data -->
<div id="successMessage" class="alert alert-success" style="display: none;">
    Data berhasil ditambahkan!
</div>

        <!-- Add DataTables Script Initialization -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            $(document).ready(function() {
                // Initialize the DataTable
                $('#dataTable').DataTable();

                // Submit form menggunakan AJAX
                $('#addForm').submit(function(e) {
                    e.preventDefault();

                    var formData = $(this).serialize(); 

                    $.ajax({
                        url: 'pelanggan/add.php',
                        type: 'POST',
                        data: formData,
                        success: function(response) {
            // Menampilkan pesan jika data berhasil ditambahkan
            alert('Data berhasil ditambahkan!');

            // Muat ulang tabel pelanggan tanpa memuat ulang seluruh halaman
            $('#content-area').load('../views/pelanggan/pelanggan.php');
            $('#addModal').modal('hide');
        },
        error: function(xhr, status, error) {
            alert("Data gagal ditambahkan.");
        }
    });
                });
            });
        </script>

    </body>

    </html>
