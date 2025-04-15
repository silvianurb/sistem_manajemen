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

    $query = "SELECT suratjalan.idsuratjalan, suratjalan.idOrder, suratjalan.tanggal_surat_jalan, 
                 suratjalan.nama_pelanggan, suratjalan.nama_barang, suratjalan.status_pengiriman
          FROM suratjalan"; // Ambil data dari tabel suratjalan
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
            <!-- Tambah Surat Jalan Button placed here -->
            <div class="mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#suratJalanModal">Tambah Surat
                    Jalan</button>
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
                                <td><?php echo $row['status_pengiriman']; ?></td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm">Edit</a>
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
                            <textarea class="form-control" id="alamatPelanggan" name="alamatPelanggan"
                                rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="sizeS" class="form-label">Size S yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeS" name="sizeS">
                        </div>

                        <div class="mb-3">
                            <label for="sizeM" class="form-label">Size M yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeM" name="sizeM">
                        </div>

                        <div class="mb-3">
                            <label for="sizeL" class="form-label">Size L yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeL" name="sizeL">
                        </div>

                        <div class="mb-3">
                            <label for="sizeXL" class="form-label">Size XL yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeXL" name="sizeXL">
                        </div>

                        <div class="mb-3">
                            <label for="sizeXXL" class="form-label">Size XXL yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeXXL" name="sizeXXL">
                        </div>

                        <div class="mb-3">
                            <label for="statusPengiriman" class="form-label">Status Pengiriman</label>
                            <select class="form-control" id="statusPengiriman" name="statusPengiriman" required>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Terkirim">Terkirim</option>
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
                    Data order berhasil dihapus.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Menampilkan data secara otomatis setelah pilih ID Order
            $('#idOrder').change(function () {
                var idOrder = $(this).val();
                if (idOrder != "") {
                    $.ajax({
                        url: 'suratjalan/get_order_data.php',
                        type: 'GET',
                        data: { idOrder: idOrder },
                        success: function (response) {
                            console.log(response); // Debug: Lihat apa yang diterima dari response
                            var data = JSON.parse(response);
                            if (data.error) {
                                alert(data.error);
                            } else {
                                $('#namaBarang').val(data.namaBarang);
                                $('#namaPelanggan').val(data.namaPelanggan);
                                // Alamat tidak diisi otomatis, hanya input manual
                            }
                        },
                        error: function () {
                            alert("Gagal mengambil data order.");
                        }
                    });
                }
            });

            // Simpan Surat Jalan
            $('#suratJalanForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize(); 
                console.log(formData); 
                $.ajax({
                    url: 'suratjalan/add.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        $('#successAddModal').modal('show');
                        $('#content-area').load('../views/suratjalan/suratjalan.php');
                        $('#suratJalanModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        alert("Terjadi kesalahan saat menyimpan Surat Jalan.");
                    }
                });
            });

            // Delete Order
            $('.deleteBtn').click(function () {
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
                                $('#content-area').load('../views/suratjalan/suratjalan.php');
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