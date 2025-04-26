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

    // Update query untuk menambahkan data ukuran
    $query = "SELECT suratjalan.idsuratjalan, suratjalan.idOrder, suratjalan.tanggal_surat_jalan, 
                 suratjalan.nama_pelanggan, suratjalan.nama_barang, suratjalan.status_pengiriman,
                 suratjalan.size_s_kirim, suratjalan.size_m_kirim, suratjalan.size_l_kirim, 
                 suratjalan.size_xl_kirim, suratjalan.size_xxl_kirim
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
                                <td><?php echo $row['status_pengiriman']; ?></td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm printBtn"
                                        data-id="<?php echo $row['idsuratjalan']; ?>">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm"><i
                                            class="fas fa-edit"></i></a>
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
                            <input type="number" class="form-control" id="sizeS" name="sizeS" value="0">
                        </div>

                        <div class="mb-3">
                            <label for="sizeM" class="form-label">Size M yang Dikirim</label>
                            <input type="number" class="form-control" id="sizeM" name="sizeM" value="0">
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
                            console.log(response);
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

            // Menangani klik tombol cetak
            $('.printBtn').click(function () {
                var idSuratJalan = $(this).data('id');
                $.ajax({
                    url: 'suratjalan/cetak_pdf.php',
                    type: 'GET',
                    data: { id: idSuratJalan },
                    success: function (response) {
                        var fileURL = response;
                        window.open(fileURL, '_blank');
                    },
                    error: function () {
                        alert("Terjadi kesalahan saat mencetak PDF.");
                    }
                });
            });

            // Menampilkan data untuk edit ketika tombol edit diklik
            $('.editBtn').click(function () {
                // Ambil data dari atribut data- di tombol
                var idSuratJalan = $(this).data('id');
                var idOrder = $(this).data('order');
                var namaBarang = $(this).data('namaBarang');
                var namaPelanggan = $(this).data('namaPelanggan');
                var alamatPelanggan = $(this).data('alamatPelanggan');
                var sizeS = $(this).data('sizeS');
                var sizeM = $(this).data('sizeM');
                var sizeL = $(this).data('sizeL');
                var sizeXL = $(this).data('sizeXL');
                var sizeXXL = $(this).data('sizeXXL');
                var status = $(this).data('status');

                // Isi modal dengan data yang diambil
                $('#editIdSuratJalan').val(idSuratJalan);
                $('#editIdOrder').val(idOrder);
                $('#editNamaBarang').val(namaBarang);
                $('#editNamaPelanggan').val(namaPelanggan);
                $('#editAlamatPelanggan').val(alamatPelanggan);
                $('#editSizeS').val(sizeS);
                $('#editSizeM').val(sizeM);
                $('#editSizeL').val(sizeL);
                $('#editSizeXL').val(sizeXL);
                $('#editSizeXXL').val(sizeXXL);
                $('#editStatusPengiriman').val(status);

                // Tampilkan modal edit
                $('#editSuratJalanModal').modal('show');
            });

        });
    </script>

</body>

</html>