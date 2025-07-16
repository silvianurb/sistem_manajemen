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
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus-circle"></i> Tambah Pelanggan
                </button>
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
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['idpelanggan']; ?>" data-nama="<?php echo $row['nama']; ?>"
                                        data-alamat="<?php echo $row['alamat']; ?>"
                                        data-kontak="<?php echo $row['kontak']; ?>"
                                        data-no_rekening="<?php echo $row['no_rekening']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?php echo $row['idpelanggan']; ?>">
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
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="kontak" name="kontak" required
                                oninput="validateKontak()">
                            <span id="kontakError" style="color: red; display: none;">Wajib angka</span>
                            <!-- Pesan Kesalahan -->
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

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAlamat" class="form-label">Alamat</label>
                            <textarea type="text" class="form-control" id="editAlamat" name="alamat"
                                required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editKontak" class="form-label">Kontak</label>
                            <input type="text" class="form-control" id="editKontak" name="kontak" required
                                oninput="validateKontakEdit()">
                            <span id="editKontakError" style="color: red; display: none;">Wajib angka</span>
                            <!-- Pesan Kesalahan -->
                        </div>
                        <div class="mb-3">
                            <label for="editNoRekening" class="form-label">No Rekening</label>
                            <input type="text" class="form-control" id="editNoRekening" name="no_rekening" required>
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
                    <p>Apakah Anda yakin ingin menghapus data pelanggan ini?</p>
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
                    Data pelanggan berhasil dihapus.
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
                    Data pelanggan berhasil ditambahkan.
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
                    Data pelanggan berhasil diperbarui.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Add DataTables Script Initialization -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // DataTable Initialization
            $('#dataTable').DataTable();

            // Insert Data
            $('#addForm').submit(function (e) {
                e.preventDefault();

                // Validasi untuk kontak
                if (document.getElementById("kontakError").style.display === "block") {
                    alert("Kontak harus berupa angka.");
                    return;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: 'pelanggan/add.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#successAddModal').modal('show');
                        $('#content-area').load('../views/pelanggan/pelanggan.php');
                        table.clear().destroy();
                        table = $('#dataTable').DataTable();
                        $('#addModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        $('#failAddModal').modal('show');
                    }
                });
            });

            // Edit Data
            $(document).on('click', '.editBtn', function () {
                // Ambil data dari atribut data-*
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var alamat = $(this).data('alamat');
                var kontak = $(this).data('kontak');
                var no_rekening = $(this).data('no_rekening');

                // Masukkan data ke dalam modal form
                $('#editId').val(id);
                $('#editNama').val(nama);
                $('#editAlamat').val(alamat);
                $('#editKontak').val(kontak);
                $('#editNoRekening').val(no_rekening);

                // Tampilkan modal edit
                $('#editModal').modal('show');
            });

            // Edit Form Submit
            $('#editForm').submit(function (e) {
                e.preventDefault();

                // Validasi untuk kontak
                if (document.getElementById("editKontakError").style.display === "block") {
                    alert("Kontak harus berupa angka.");
                    return;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: 'pelanggan/edit.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#successEditModal').modal('show');
                        $('#content-area').load('../views/pelanggan/pelanggan.php');
                        table.clear().destroy();
                        table = $('#dataTable').DataTable();
                        $('#editModal').modal('hide');
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
                        url: 'pelanggan/delete.php?id=' + id,
                        type: 'GET',
                        success: function (response) {
                            if (response.trim() == "success") {
                                $('#deleteModal').modal('hide');
                                $('#successDeleteModal').modal('show');
                                $('#content-area').load('../views/pelanggan/pelanggan.php');
                                table.clear().destroy();
                                table = $('#dataTable').DataTable();
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

        // Fungsi validasi untuk kolom "Kontak" di form tambah
        function validateKontak() {
            var kontak = document.getElementById("kontak").value;
            if (!/^\d+$/.test(kontak)) { // Jika input bukan angka
                document.getElementById("kontakError").style.display = "block";
            } else {
                document.getElementById("kontakError").style.display = "none";
            }
        }

        // Fungsi validasi untuk kolom "Kontak" di form edit
        function validateKontakEdit() {
            var kontak = document.getElementById("editKontak").value;
            if (!/^\d+$/.test(kontak)) { // Jika input bukan angka
                document.getElementById("editKontakError").style.display = "block"; // Menampilkan pesan kesalahan
            } else {
                document.getElementById("editKontakError").style.display = "none"; // Menyembunyikan pesan kesalahan jika input benar
            }
        }
    </script>

</body>

</html>