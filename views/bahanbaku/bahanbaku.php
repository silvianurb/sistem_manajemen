<?php
session_start();
include_once('../../config/config.php');
check_login();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <?php
    require_once('../../config/config.php');
    $query = "SELECT * FROM bahanbaku";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Bahan Baku</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus-circle"></i> Tambah Bahan Baku
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Bahan Baku</th>
                            <th>Nama Bahan</th>
                            <th>Stok</th>
                            <th>Satuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['idBahanBaku']; ?></td>
                                <td><?php echo $row['namaBahan']; ?></td>
                                <td><?php echo $row['stok']; ?></td>
                                <td><?php echo $row['satuan']; ?></td>

                                <td>
                                    <?php
                                    $stok = $row['stok'];
                                    if ($stok > 50) {
                                        echo '<span class="badge bg-success text-light">Tersedia</span>';
                                    } elseif ($stok > 0 && $stok <= 50) {
                                        echo '<span class="badge bg-primary text-light">Menipis</span>';
                                    } else {
                                        echo '<span class="badge bg-danger text-light">Habis</span>';
                                    }
                                    ?>
                                </td>

                                <td>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['idBahanBaku']; ?>"
                                        data-nama="<?php echo $row['namaBahan']; ?>" data-stok="<?php echo $row['stok']; ?>"
                                        data-satuan="<?php echo $row['satuan']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?php echo $row['idBahanBaku']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
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
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Bahan Baku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="namaBahan" class="form-label">Nama Bahan</label>
                            <input type="text" class="form-control" id="namaBahan" name="namaBahan" required>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-control" id="satuan" name="satuan" required>
                                <option value="Meter">Meter</option>
                                <option value="Pcs">Pcs</option>
                                <option value="Rol">Rol</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Bahan Baku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editIdBahanBaku" name="idBahanBaku">
                        <div class="mb-3">
                            <label for="editNamaBahan" class="form-label">Nama Bahan</label>
                            <input type="text" class="form-control" id="editNamaBahan" name="namaBahan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="editStok" name="stok" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSatuan" class="form-label">Satuan</label>
                            <select class="form-control" id="editSatuan" name="satuan" required>
                                <option value="Meter" id="satuanMeter">Meter</option>
                                <option value="Pcs" id="satuanPcs">Pcs</option>
                                <option value="Rol" id="satuanRol">Rol</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data bahan baku ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a id="deleteConfirmBtn" href="#" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pesan Sukses Penghapusan -->
    <div class="modal fade" id="successDeleteModal" tabindex="-1" aria-labelledby="successDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successDeleteModalLabel">Sukses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data bahan baku berhasil dihapus.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pesan Sukses Penambahan -->
    <div class="modal fade" id="successAddModal" tabindex="-1" aria-labelledby="successAddModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successAddModalLabel">Sukses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data bahan baku berhasil ditambahkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pesan Sukses Edit -->
    <div class="modal fade" id="successEditModal" tabindex="-1" aria-labelledby="successEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successEditModalLabel">Sukses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data bahan baku berhasil diperbarui.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();

            // Insert Data
            $('#addForm').submit(function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: 'bahanbaku/add.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#addModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('#successAddModal').modal('show');
                        $('#content-area').load('../views/bahanbaku/bahanbaku.php');
                    },
                    error: function (xhr, status, error) {
                        alert("Data gagal ditambahkan.");
                    }
                });
            });

            // Edit Data
            $(document).on('click', '.editBtn', function () {
                var id = $(this).data('id');
                var namaBahan = $(this).data('nama');
                var stok = $(this).data('stok');
                var satuan = $(this).data('satuan');

                $('#editIdBahanBaku').val(id);
                $('#editNamaBahan').val(namaBahan);
                $('#editStok').val(stok);
                $('#editSatuan').val(satuan);

                $('#editModal').modal('show');
            });

            // Update Data
            $('#editForm').submit(function (e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: 'bahanbaku/edit.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#editModal').modal('hide');
                        $('#successEditModal').modal('show');
                        $('#content-area').load('../views/bahanbaku/bahanbaku.php');
                    },
                    error: function (xhr, status, error) {
                        alert("Data gagal diperbarui.");
                    }
                });
            });

            // Delete Data
            $(document).on('click', '.deleteBtn', function () {
                var id = $(this).data('id');
                $('#deleteConfirmBtn').attr('href', 'javascript:void(0);');
                $('#deleteModal').modal('show');
                $('#deleteConfirmBtn').click(function () {
                    $.ajax({
                        url: 'bahanbaku/delete.php?id=' + id,
                        type: 'GET',
                        success: function (response) {
                            console.log(response);
                            if (response.trim() == "success") {
                                $('#deleteModal').modal('hide');
                                $('#successDeleteModal').modal('show');
                                $('#content-area').empty();
                                $('#content-area').load('../views/bahanbaku/bahanbaku.php');
                            } else {
                                alert("Gagal menghapus data.");
                            }
                        },
                        error: function (xhr, status, error) {
                            alert("Terjadi kesalahan saat menghapus data.");
                        }
                    });
                });
            });
        });
    </script>

</body>

</html>