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
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Pengguna</h6>
        </div>
        <div class="card-body">
            <!-- Tambah Data Button placed here -->
            <div class="mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="fa fa-plus-circle"></i> Tambah Pengguna
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pengguna</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Waktu Dibuat</th>
                            <th>Password</th> <!-- Menampilkan password hash -->
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['username']; ?></td>
                                <td><?php echo $row['namaUser']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td><?php echo $row['created_at']; ?></td>
                                <td><?php echo $row['password']; ?></td> <!-- Menampilkan hasil hash -->
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['id']; ?>" data-username="<?php echo $row['username']; ?>"
                                        data-nama="<?php echo $row['namaUser']; ?>" data-role="<?php echo $row['role']; ?>"
                                        data-password="<?php echo $row['password']; ?>"
                                        data-created_at="<?php echo $row['created_at']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?php echo $row['id']; ?>">
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
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="namaUser" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="manajer">Manajer</option>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="editNama" name="namaUser" required>
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="editPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="editRole" class="form-label">Role</label>
                            <select class="form-control" id="editRole" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="petugas">Petugas</option>
                                <option value="manajer">Manajer</option>
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
                    <p>Apakah Anda yakin ingin menghapus data pengguna ini?</p>
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
                    Data pengguna berhasil dihapus.
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
                    Data pengguna berhasil ditambahkan.
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
                    Data pengguna berhasil diperbarui.
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
            $('#dataTable').DataTable();
            // Insert Data
            $('#addForm').submit(function (e) {
                e.preventDefault();

                var password = $('#password').val();
                if (password.length < 8) {
                    alert('Password harus terdiri dari minimal 8 karakter.');
                    return false;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: 'pengguna/add.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#successAddModal').modal('show');
                        $('#content-area').load('../views/pengguna/pengguna.php');
                        $('#addModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        alert("Data gagal ditambahkan.");
                    }
                });
            });

            // Edit Data
            $(document).on('click', '.editBtn', function () {
                var id = $(this).data('id');
                var username = $(this).data('username');
                var namaUser = $(this).data('nama');
                var role = $(this).data('role');
                var password = "";

                $('#editId').val(id);
                $('#editUsername').val(username);
                $('#editNama').val(namaUser);
                $('#editRole').val(role);

                $('#editModal').modal('show');
            });

            // Update Data
            $('#editForm').submit(function (e) {
                e.preventDefault();

                var password = $('#editPassword').val();
                if (password.length < 8) {
                    alert('Password harus terdiri dari minimal 8 karakter.');
                    return false;
                }

                var formData = $(this).serialize();

                $.ajax({
                    url: 'pengguna/edit.php',  // Ubah URL sesuai dengan lokasi file edit.php
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#successEditModal').modal('show');
                        $('#content-area').load('../views/pengguna/pengguna.php');
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
                        url: 'pengguna/delete.php?id=' + id,
                        type: 'GET',
                        success: function (response) {
                            if (response.trim() == "success") {
                                $('#deleteModal').modal('hide');
                                $('#successDeleteModal').modal('show');
                                $('#content-area').load('../views/pengguna/pengguna.php');
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