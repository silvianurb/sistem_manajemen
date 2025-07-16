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

    // Update query untuk menambahkan data ukuran
    $query = "SELECT suratjalan.idsuratjalan, suratjalan.tanggal_surat_jalan, 
                 suratjalan.nama_pelanggan, suratjalan.alamat_pelanggan, 
                 suratjalan.nama_barang, suratjalan.status_pengiriman
          FROM suratjalan";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tugas Distribusi Barang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Surat Jalan</th>
                            <th>Tanggal Surat Jalan</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat Pelanggan</th>
                            <th>Nama Barang</th>
                            <th>Status Pengiriman</th>
                            <th>Aksi</th> <!-- Aksi hanya untuk tombol edit dan cetak -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['idsuratjalan']; ?></td>
                                <td><?php echo $row['tanggal_surat_jalan']; ?></td>
                                <td><?php echo $row['nama_pelanggan']; ?></td>
                                <td><?php echo $row['alamat_pelanggan']; ?></td>
                                <td><?php echo $row['nama_barang']; ?></td>
                                <td>
                                    <?php
                                    $statusClass = ($row['status_pengiriman'] == 'Terkirim') ? 'bg-success' : 'bg-primary';
                                    ?>
                                    <span
                                        class="badge <?php echo $statusClass; ?> text-light"><?php echo $row['status_pengiriman']; ?></span>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm printBtn"
                                        data-id="<?php echo $row['idsuratjalan']; ?>">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['idsuratjalan']; ?>"
                                        data-tanggal="<?php echo $row['tanggal_surat_jalan']; ?>"
                                        data-nama-pelanggan="<?php echo $row['nama_pelanggan']; ?>"
                                        data-alamat-pelanggan="<?php echo $row['alamat_pelanggan']; ?>"
                                        data-nama-barang="<?php echo $row['nama_barang']; ?>"
                                        data-status="<?php echo $row['status_pengiriman']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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

                        <!-- Tanggal Surat Jalan (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editTanggalSuratJalan" class="form-label">Tanggal Surat Jalan</label>
                            <input type="date" class="form-control" id="editTanggalSuratJalan" name="tanggalSuratJalan"
                                readonly required>
                        </div>

                        <!-- Nama Pelanggan (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editNamaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="editNamaPelanggan" name="namaPelanggan" readonly
                                required>
                        </div>

                        <!-- Alamat Pelanggan (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editAlamatPelanggan" class="form-label">Alamat Pelanggan</label>
                            <input type="text" class="form-control" id="editAlamatPelanggan" name="alamatPelanggan"
                                readonly required>
                        </div>

                        <!-- Nama Barang (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editNamaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editNamaBarang" name="namaBarang" readonly
                                required>
                        </div>

                        <!-- Status Pengiriman (Hanya Ini yang Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editStatusPengiriman" class="form-label">Status Pengiriman</label>
                            <select class="form-control" id="editStatusPengiriman" name="statusPengiriman" required>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Terkirim">Terkirim</option>
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
                    Status Pengiriman berhasil diperbarui
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

            // Menangani klik tombol edit
            $(document).on('click', '.editBtn', function () {
                var idSuratJalan = $(this).data('id');
                var tanggalSuratJalan = $(this).data('tanggal');
                var namaPelanggan = $(this).data('nama-pelanggan');
                var alamatPelanggan = $(this).data('alamat-pelanggan');
                var namaBarang = $(this).data('nama-barang');
                var statusPengiriman = $(this).data('status');

                // Menyisipkan data yang diambil ke dalam modal
                $('#editIdSuratJalan').val(idSuratJalan);
                $('#editTanggalSuratJalan').val(tanggalSuratJalan);
                $('#editNamaPelanggan').val(namaPelanggan);
                $('#editAlamatPelanggan').val(alamatPelanggan);
                $('#editNamaBarang').val(namaBarang);
                $('#editStatusPengiriman').val(statusPengiriman);

                // Menampilkan modal untuk melakukan edit
                $('#editSuratJalanModal').modal('show');
            });

            // Menangani pengiriman form edit
            $('#editSuratJalanForm').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'distribusi/edit.php',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response); // Menambahkan log untuk melihat respons yang diterima
                        var data = JSON.parse(response);
                        if (data.success) {
                            $('#editSuratJalanModal').modal('hide');
                            $('#successEditModal').modal('show');
                            $('#content-area').load('../views/distribusi/distribusi.php');
                            table.clear().destroy();
                            table = $('#dataTable').DataTable();
                        } else {
                            alert('Terjadi kesalahan saat memperbarui data.');
                        }
                    }
                });
            });

        });
    </script>

</body>

</html>