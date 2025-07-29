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
    include_once('../../config/config.php');

    // Update query untuk menambahkan data ukuran
    $query = "SELECT suratjalan.idsuratjalan, suratjalan.idOrder, suratjalan.tanggal_surat_jalan, 
                 suratjalan.nama_pelanggan, suratjalan.nama_barang, suratjalan.status_pengiriman,
                 suratjalan.size_s_kirim, suratjalan.size_m_kirim, suratjalan.size_l_kirim, 
                 suratjalan.size_xl_kirim, suratjalan.size_xxl_kirim
          FROM suratjalan";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Surat Jalan</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-primary" data-toggle="modal" data-target="#suratJalanModal">
                    <i class="fa fa-plus-circle"></i> Tambah Surat Jalan
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Surat Jalan</th>
                            <th>ID Order</th>
                            <th>Tanggal Surat Jalan</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Barang</th>
                            <th>S</th>
                            <th>M</th>
                            <th>L</th>
                            <th>XL</th>
                            <th>XXL</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['idsuratjalan']; ?></td>
                                <td><?php echo $row['idOrder']; ?></td>
                                <td><?php echo $row['tanggal_surat_jalan']; ?></td>
                                <td><?php echo $row['nama_pelanggan']; ?></td>
                                <td><?php echo $row['nama_barang']; ?></td>
                                <td><?php echo $row['size_s_kirim']; ?></td>
                                <td><?php echo $row['size_m_kirim']; ?></td>
                                <td><?php echo $row['size_l_kirim']; ?></td>
                                <td><?php echo $row['size_xl_kirim']; ?></td>
                                <td><?php echo $row['size_xxl_kirim']; ?></td>
                                <td>
                                    <?php
                                    $status = $row['status_pengiriman'];
                                    if ($status == 'Dikirim') {
                                        echo '<span class="badge bg-success status-circle text-white">Dikirim</span>';
                                    } elseif ($status == 'Terkirim') {
                                        echo '<span class="badge bg-warning status-circle text-white">Terkirim</span>';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm printBtn"
                                        data-id="<?php echo $row['idsuratjalan']; ?>">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['idsuratjalan']; ?>"
                                        data-tanggal="<?php echo $row['tanggal_surat_jalan']; ?>"
                                        data-size-s="<?php echo $row['size_s_kirim']; ?>"
                                        data-size-m="<?php echo $row['size_m_kirim']; ?>"
                                        data-size-l="<?php echo $row['size_l_kirim']; ?>"
                                        data-size-xl="<?php echo $row['size_xl_kirim']; ?>"
                                        data-size-xxl="<?php echo $row['size_xxl_kirim']; ?>"
                                        data-status="<?php echo $row['status_pengiriman']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>


                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?php echo $row['idsuratjalan']; ?>">
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

    <!-- Modal Tambah Surat Jalan -->
    <div class="modal fade" id="suratJalanModal" tabindex="-1" aria-labelledby="suratJalanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="suratJalanModalLabel">Tambah Surat Jalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="suratJalanForm">

                        <div class="mb-3">
                            <label for="tanggalSuratJalan" class="form-label">Tanggal Surat Jalan</label>
                            <input type="date" class="form-control" id="tanggalSuratJalan" name="tanggalSuratJalan"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="idOrder" class="form-label">ID Order</label>
                            <select class="form-control" id="idOrder" name="idOrder" required>
                                <option value="">Pilih ID Order</option>
                                <?php
                                // Ambil data idOrder dari tabel pesanan
                                $query = "SELECT idOrder FROM pesanan";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['idOrder'] . "'>" . $row['idOrder'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="alamatPelanggan" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamatPelanggan" name="alamatPelanggan" rows="3"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sizeS" class="form-label">Size S yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeS" name="sizeS" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="sizeM" class="form-label">Size M yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeM" name="sizeM" value="0" min="0">
                            <div class="error-msg text-danger" id="error-sizeS"></div>
                        </div>

                        <div class="mb-3">
                            <label for="sizeL" class="form-label">Size L yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeL" name="sizeL" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="sizeXL" class="form-label">Size XL yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeXL" name="sizeXL" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="sizeXXL" class="form-label">Size XXL yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeXXL" name="sizeXXL" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="statusPengiriman" class="form-label">Status Pengiriman</label>
                            <select class="form-control" id="statusPengiriman" name="statusPengiriman" required
                                disabled>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Terkirim">Terkirim</option>
                            </select>
                            <!-- Input hidden untuk mengirim nilai -->
                            <input type="hidden" name="statusPengiriman" value="Dikirim" />
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
                    Data surat jalan berhasil ditambahkan.
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
                    <p>Apakah Anda yakin ingin menghapus data surat jalan ini?</p>
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
                    Data surat jalan berhasil dihapus.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Surat Jalan -->
    <div class="modal fade" id="editSuratJalanModal" tabindex="-1" aria-labelledby="editSuratJalanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSuratJalanModalLabel">Edit Surat Jalan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSuratJalanForm">
                        <input type="hidden" id="editIdSuratJalan" name="idSuratJalan">
                        <div class="mb-3">
                            <label for="editTanggalSuratJalan" class="form-label">Tanggal Surat Jalan</label>
                            <input type="date" class="form-control" id="editTanggalSuratJalan" name="tanggalSuratJalan"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeS" class="form-label">Size S yang Dikirim</label>
                            <input type="number" class="form-control" id="editSizeS" name="sizeS" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeM" class="form-label">Size M yang Dikirim</label>
                            <input type="number" class="form-control" id="editSizeM" name="sizeM" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeL" class="form-label">Size L yang Dikirim</label>
                            <input type="number" class="form-control" id="editSizeL" name="sizeL" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeXL" class="form-label">Size XL yang Dikirim</label>
                            <input type="number" class="form-control" id="editSizeXL" name="sizeXL" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeXXL" class="form-label">Size XXL yang Dikirim</label>
                            <input type="number" class="form-control" id="editSizeXXL" name="sizeXXL" value="0"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="editStatusPengiriman" class="form-label">Status Pengiriman</label>
                            <select class="form-control" id="editStatusPengiriman" name="statusPengiriman" required
                                disabled>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Terkirim">Terkirim</option>
                            </select>
                            <!-- Input hidden untuk mengirim nilai -->
                            <input type="hidden" name="statusPengiriman" value="Dikirim" />
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
                    Data surat jalan berhasil diperbarui
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
            // Inisialisasi DataTable
            $('#dataTable').DataTable();

           
            $('#idOrder').change(handleOrderChange);
            $('#suratJalanForm').submit(handleFormSubmit);

            $(document).on('click', '.deleteBtn', handleDelete);

            $('.printBtn').click(handlePrint);


            $(document).on('click', '.editBtn', handleEdit);

            // Menangani pengiriman form edit
            $('#editSuratJalanForm').submit(handleEditSubmit);
        });

        // Fungsi untuk menangani perubahan ID Order
        function handleOrderChange() {
            var idOrder = $(this).val();
            if (idOrder != "") {
                $.ajax({
                    url: 'suratjalan/get_order_data.php',
                    type: 'GET',
                    data: { idOrder: idOrder },
                    success: function (response) {
                        var data = JSON.parse(response);
                        if (data.error) {
                            alert(data.error);
                        } else {
                            $('#namaBarang').val(data.namaBarang);
                            $('#namaPelanggan').val(data.namaPelanggan);
                        }
                    },
                    error: function () {
                        alert("Gagal mengambil data order.");
                    }
                });
            }
        }

        // Fungsi untuk menangani pengiriman form Surat Jalan
        function handleFormSubmit(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'suratjalan/add.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    $('#suratJalanModal').modal('hide');
                    $('#successAddModal').modal('show');
                    $('.modal-backdrop').remove();
                    $('#content-area').load('../views/suratjalan/suratjalan.php');
                },
                error: function () {
                    alert("Terjadi kesalahan saat menyimpan Surat Jalan.");
                }
            });
        }

        // Fungsi untuk menangani penghapusan data
        function handleDelete() {
            var id = $(this).data('id');
            $('#deleteConfirmBtn').attr('href', 'javascript:void(0);');
            $('#deleteModal').modal('show');
            $('#deleteConfirmBtn').click(function () {
                $.ajax({
                    url: 'suratjalan/delete.php?id=' + id,
                    type: 'GET',
                    success: function (response) {
                        if (response.trim() == "success") {
                            $('#deleteModal').modal('hide');
                            $('#successDeleteModal').modal('show');
                            $('#content-area').empty();
                            $('#content-area').load('../views/suratjalan/suratjalan.php');
                        } else {
                            alert("Data Sudah Terdaftar Invoice");
                        }
                    },
                    error: function () {
                        alert("Terjadi kesalahan saat menghapus data.");
                    }
                });
            });
        }

        // Fungsi untuk menangani cetak PDF
        function handlePrint() {
            var idSuratJalan = $(this).data('id');
            $.ajax({
                url: 'suratjalan/cetak_pdf.php',
                type: 'GET',
                data: { id: idSuratJalan },
                success: function (response) {
                    window.open(response, '_blank');
                },
                error: function () {
                    alert("Terjadi kesalahan saat mencetak PDF.");
                }
            });
        }

        // Fungsi untuk menangani edit data
        function handleEdit() {
            var idSuratJalan = $(this).data('id');
            var tanggalSuratJalan = $(this).data('tanggal');
            var sizeS = $(this).data('size-s');
            var sizeM = $(this).data('size-m');
            var sizeL = $(this).data('size-l');
            var sizeXL = $(this).data('size-xl');
            var sizeXXL = $(this).data('size-xxl');
            var statusPengiriman = $(this).data('status');

            $('#editIdSuratJalan').val(idSuratJalan);
            $('#editTanggalSuratJalan').val(tanggalSuratJalan);
            $('#editSizeS').val(sizeS);
            $('#editSizeM').val(sizeM);
            $('#editSizeL').val(sizeL);
            $('#editSizeXL').val(sizeXL);
            $('#editSizeXXL').val(sizeXXL);
            $('#editStatusPengiriman').val(statusPengiriman);

            $('#editSuratJalanModal').modal('show');
        }

        // Fungsi untuk menangani pengiriman form edit
        function handleEditSubmit(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: 'suratjalan/edit.php',
                type: 'POST',
                data: formData,
                success: function (response) {
                    try {
                        var data = JSON.parse(response);
                        if (data.success) {
                            $('#editSuratJalanModal').modal('hide');
                            $('#successEditModal').modal('show');
                            $('#content-area').load('../views/suratjalan/suratjalan.php');
                        } else {
                            alert('Terjadi kesalahan saat memperbarui data.');
                        }
                    } catch (e) {
                        console.error("Error parsing JSON: ", e);
                        alert("Terjadi kesalahan saat menerima respons dari server.");
                    }
                }
            });
        }

    </script>

</body>

</html>