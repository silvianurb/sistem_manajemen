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
    // Query untuk mengambil data pesanan dengan JOIN untuk mendapatkan nama pelanggan
    $query = "SELECT pesanan.idOrder, pesanan.namaPelanggan, pesanan.tanggalPesanan, pesanan.namaBarang, 
            pesanan.sizeS, pesanan.sizeM, pesanan.sizeL, pesanan.sizeXL, pesanan.sizeXXL, pesanan.bahan, 
            pesanan.sisaKirim, pesanan.status
            FROM pesanan
            JOIN pelanggan ON pesanan.namaPelanggan = pelanggan.nama;"; // Mengambil hanya nama pelanggan
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Order</h6>
        </div>
        <div class="card-body">
            <!-- Tambah Data Order Button placed here -->
            <div class="mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Tambah Order</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal Pesanan</th>
                            <th>Nama Barang</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                            <th>Bahan</th>
                            <th>Sisa Kirim</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['idOrder']; ?></td>
                                <td><?php echo $row['namaPelanggan']; ?></td>
                                <td><?php echo $row['tanggalPesanan']; ?></td>
                                <td><?php echo $row['namaBarang']; ?></td>
                                <td><?php echo $row['sizeS']; ?></td>
                                <td><?php echo $row['sizeM']; ?></td>
                                <td><?php echo $row['sizeL']; ?></td>
                                <td><?php echo $row['sizeXL']; ?></td>
                                <td><?php echo $row['sizeXXL']; ?></td>
                                <td><?php echo $row['bahan']; ?></td>
                                <td><?php echo $row['sisaKirim']; ?></td>
                                <td>
                                    <?php
                                    // Menentukan warna berdasarkan status
                                    $status = $row['status'];
                                    if ($status == 'Pending') {
                                        echo '<span class="badge bg-warning text-light">Pending</span>';
                                    } elseif ($status == 'Diproses') {
                                        echo '<span class="badge bg-primary text-light">Diproses</span>';
                                    } elseif ($status == 'Dikirim') {
                                        echo '<span class="badge bg-info text-light">Dikirim</span>';
                                    } elseif ($status == 'Selesai') {
                                        echo '<span class="badge bg-success text-light">Selesai</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['idOrder']; ?>"
                                        data-namaPelanggan="<?php echo $row['namaPelanggan']; ?>"
                                        data-tanggalPesanan="<?php echo $row['tanggalPesanan']; ?>"
                                        data-namaBarang="<?php echo $row['namaBarang']; ?>"
                                        data-sizeS="<?php echo $row['sizeS']; ?>" data-sizeM="<?php echo $row['sizeM']; ?>"
                                        data-sizeL="<?php echo $row['sizeL']; ?>"
                                        data-sizeXL="<?php echo $row['sizeXL']; ?>"
                                        data-sizeXXL="<?php echo $row['sizeXXL']; ?>"
                                        data-bahan="<?php echo $row['bahan']; ?>"
                                        data-sisaKirim="<?php echo $row['sisaKirim']; ?>"
                                        data-status="<?php echo $row['status']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?php echo $row['idOrder']; ?>">
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

    <!-- Modal Tambah Order -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <input type="hidden" id="sisaKirimHidden" name="sisaKirim">
                        <div class="mb-3">
                            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                            <select class="form-control" id="namaPelanggan" name="namaPelanggan" required>
                                <?php
                                // Ambil daftar nama pelanggan dari tabel pelanggan
                                require_once('../../config/config.php');
                                $query = "SELECT idpelanggan, nama FROM pelanggan";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>"; // Mengubah value menjadi nama pelanggan
                                }
                                ?>
                            </select>
                        </div>


                        <div class="mb-3">
                            <label for="tanggalPesanan" class="form-label">Tanggal Pesanan</label>
                            <input type="date" class="form-control" id="tanggalPesanan" name="tanggalPesanan" required>
                        </div>
                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="sizeS" class="form-label">Size S</label>
                            <input type="number" class="form-control" id="sizeS" name="sizeS" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="sizeM" class="form-label">Size M</label>
                            <input type="number" class="form-control" id="sizeM" name="sizeM" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="sizeL" class="form-label">Size L</label>
                            <input type="number" class="form-control" id="sizeL" name="sizeL" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="sizeXL" class="form-label">Size XL</label>
                            <input type="number" class="form-control" id="sizeXL" name="sizeXL" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="sizeXXL" class="form-label">Size XXL</label>
                            <input type="number" class="form-control" id="sizeXXL" name="sizeXXL" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="bahan" class="form-label">Bahan</label>
                            <input type="text" class="form-control" id="bahan" name="bahan" required>
                        </div>
                        <div class="mb-3">
                            <label for="sisaKirim" class="form-label">Sisa Kirim</label>
                            <input type="number" class="form-control" id="sisaKirim" name="sisaKirim" required readonly>
                            <!-- <input type="hidden" id="sisaKirimHidden" name="sisaKirim"> -->
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
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
                    Data order berhasil ditambahkan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Order -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editIdOrder" class="form-label">ID Order</label>
                            <input type="text" class="form-control" id="editIdOrder" name="idOrder" readonly>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="mb-3">
                            <label for="editNamaPelanggan" class="form-label">Nama Pelanggan</label>
                            <select class="form-control" id="editNamaPelanggan" name="namaPelanggan" required>
                                <?php
                                // Ambil daftar nama pelanggan dari tabel pelanggan
                                require_once('../../config/config.php');
                                $query = "SELECT idpelanggan, nama FROM pelanggan";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['nama'] . "'>" . $row['nama'] . "</option>";
                                }
                                ?>

                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggalPesanan" class="form-label">Tanggal Pesanan</label>
                            <input type="date" class="form-control" id="editTanggalPesanan" name="tanggalPesanan"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="editNamaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editNamaBarang" name="namaBarang" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSizeS" class="form-label">Size S</label>
                            <input type="number" class="form-control" id="editSizeS" name="sizeS" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="editSizeM" class="form-label">Size M</label>
                            <input type="number" class="form-control" id="editSizeM" name="sizeM" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="editSizeL" class="form-label">Size L</label>
                            <input type="number" class="form-control" id="editSizeL" name="sizeL" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="editSizeXL" class="form-label">Size XL</label>
                            <input type="number" class="form-control" id="editSizeXL" name="sizeXL" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="editSizeXXL" class="form-label">Size XXL</label>
                            <input type="number" class="form-control" id="editSizeXXL" name="sizeXXL" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="editBahan" class="form-label">Bahan</label>
                            <input type="text" class="form-control" id="editBahan" name="bahan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSisaKirim" class="form-label">Sisa Kirim</label>
                            <input type="number" class="form-control" id="editSisaKirim" name="sisaKirim" required
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
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
                    Data order berhasil diperbarui.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
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
                    <p>Apakah Anda yakin ingin menghapus data order ini?</p>
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
                    Data order berhasil dihapus.
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

            // Fungsi untuk menghitung sisa kirim pada form tambah order
            function calculateSisaKirim() {
                var sizeS = parseInt(document.getElementById('sizeS').value) || 0;
                var sizeM = parseInt(document.getElementById('sizeM').value) || 0;
                var sizeL = parseInt(document.getElementById('sizeL').value) || 0;
                var sizeXL = parseInt(document.getElementById('sizeXL').value) || 0;
                var sizeXXL = parseInt(document.getElementById('sizeXXL').value) || 0;

                var sisaKirim = sizeS + sizeM + sizeL + sizeXL + sizeXXL;
                document.getElementById('sisaKirim').value = sisaKirim;
                document.getElementById('sisaKirimHidden').value = sisaKirim;
            }

            // Fungsi untuk menghitung sisa kirim pada modal edit
            function calculateSisaKirimEdit() {
                var sizeS = parseInt(document.getElementById('editSizeS').value) || 0;
                var sizeM = parseInt(document.getElementById('editSizeM').value) || 0;
                var sizeL = parseInt(document.getElementById('editSizeL').value) || 0;
                var sizeXL = parseInt(document.getElementById('editSizeXL').value) || 0;
                var sizeXXL = parseInt(document.getElementById('editSizeXXL').value) || 0;

                var sisaKirim = sizeS + sizeM + sizeL + sizeXL + sizeXXL;
                document.getElementById('editSisaKirim').value = sisaKirim;
            }

            // Setiap kali ukuran berubah pada form tambah, hitung ulang Sisa Kirim
            $('#sizeS, #sizeM, #sizeL, #sizeXL, #sizeXXL').on('input', calculateSisaKirim);

            // Setiap kali ukuran berubah pada modal edit, hitung ulang Sisa Kirim
            $('#editSizeS, #editSizeM, #editSizeL, #editSizeXL, #editSizeXXL').on('input', calculateSisaKirimEdit);


            // Insert Data
            $('#addForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'order/add.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#successAddModal').modal('show');
                        $('#content-area').load('../views/order/order.php');
                        $('#addModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        alert("Data gagal ditambahkan.");
                    }
                });
            });

            // Edit Data
            $('.editBtn').click(function () {
                var id = $(this).data('id');
                var namaPelanggan = $(this).data('namapelanggan');
                var tanggalPesanan = $(this).data('tanggalpesanan');
                var namaBarang = $(this).data('namabarang');
                var sizeS = $(this).data('sizes');
                var sizeM = $(this).data('sizem');
                var sizeL = $(this).data('sizel');
                var sizeXL = $(this).data('sizexl');
                var sizeXXL = $(this).data('sizexxl');
                var bahan = $(this).data('bahan');
                var sisaKirim = $(this).data('sisakirim');
                var status = $(this).data('status');

                var formattedDate = new Date(tanggalPesanan).toISOString().split('T')[0];

                // Populate modal fields with data
                $('#editIdOrder').val(id);
                $('#editNamaPelanggan').val(namaPelanggan);
                $('#editTanggalPesanan').val(formattedDate);
                $('#editNamaBarang').val(namaBarang);
                $('#editSizeS').val(sizeS);
                $('#editSizeM').val(sizeM);
                $('#editSizeL').val(sizeL);
                $('#editSizeXL').val(sizeXL);
                $('#editSizeXXL').val(sizeXXL);
                $('#editBahan').val(bahan);
                $('#editSisaKirim').val(sisaKirim);
                $('#editStatus').val(status);

                // Ensure sisa kirim is recalculated if needed
                calculateSisaKirimEdit();

                // Show the modal
                $('#editModal').modal('show');
            });

            // Update Data
            $('#editForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                console.log("Form Data being sent: ", formData); 
                $.ajax({
                    url: 'order/edit.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);  // Cek response dari server
                        $('#successEditModal').modal('show');
                        $('#content-area').load('../views/order/order.php');
                        $('#editModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        console.log('Error:', error);  // Log error jika ada masalah
                        alert("Data gagal diperbarui.");
                    }
                });
            });

            // Delete Data
            $('.deleteBtn').click(function () {
                var id = $(this).data('id');
                $('#deleteConfirmBtn').attr('href', 'javascript:void(0);');
                $('#deleteModal').modal('show');
                $('#deleteConfirmBtn').click(function () {
                    $.ajax({
                        url: 'order/delete.php?id=' + id,
                        type: 'GET',
                        success: function (response) {
                            if (response.trim() == "success") {
                                $('#deleteModal').modal('hide');
                                $('#successDeleteModal').modal('show');
                                $('#content-area').load('../views/order/order.php');
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