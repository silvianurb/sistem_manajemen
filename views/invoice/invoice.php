<?php
session_start();
include_once('../../config/config.php');\
check_login();

// Query untuk mengambil data invoice
$query = "SELECT invoice.idInvoice, invoice.tanggal_invoice, invoice.idSuratJalan, invoice.nama_pelanggan, 
                 invoice.nama_barang, invoice.total_bayar 
          FROM invoice";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Invoice</h6>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invoiceModal">
                    <i class="fa fa-plus-circle"></i> Tambah Invoice
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Invoice</th>
                            <th>Tanggal Invoice</th>
                            <th>ID Surat Jalan</th>
                            <th>Nama Pelanggan</th>
                            <th>Nama Barang</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo $row['idInvoice']; ?></td>
                                <td><?php echo $row['tanggal_invoice']; ?></td>
                                <td><?php echo $row['idSuratJalan']; ?></td>
                                <td><?php echo $row['nama_pelanggan']; ?></td>
                                <td><?php echo $row['nama_barang']; ?></td>
                               <td><?php echo "Rp " . number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                                <td>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm printBtn"
                                        data-id="<?php echo $row['idInvoice']; ?>">
                                        <i class="fas fa-print"></i>
                                    </a>

                                    <a href="javascript:void(0);" class="btn btn-warning btn-sm editBtn"
                                        data-id="<?php echo $row['idInvoice']; ?>" data-bs-toggle="modal"
                                        data-bs-target="#editInvoiceModal">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteBtn"
                                        data-id="<?php echo $row['idInvoice']; ?>">
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

    <!-- Modal Tambah Invoice -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoiceModalLabel">Tambah Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="invoiceForm">
                        <!-- ID Invoice (Auto-generated) -->
                        <div class="mb-3">
                            <label for="idInvoice" class="form-label">ID Invoice</label>
                            <input type="text" class="form-control" id="idInvoice" name="idInvoice" readonly>
                        </div>

                        <!-- Tanggal Invoice -->
                        <div class="mb-3">
                            <label for="tanggalInvoice" class="form-label">Tanggal Invoice</label>
                            <input type="date" class="form-control" id="tanggalInvoice" name="tanggalInvoice" required>
                        </div>

                        <!-- ID Surat Jalan -->
                        <div class="mb-3">
                            <label for="idSuratJalan" class="form-label">ID Surat Jalan</label>
                            <select class="form-control" id="idSuratJalan" name="idSuratJalan" required>
                                <option value="">Pilih ID Surat Jalan</option>
                                <?php
                                // Ambil ID Surat Jalan yang belum terpakai
                                $query = "SELECT idsuratjalan FROM suratjalan WHERE idsuratjalan NOT IN (SELECT idSuratJalan FROM invoice)";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $idSuratJalan = $row['idsuratjalan'];
                                    // Cek apakah ID Surat Jalan sudah digunakan
                                    $isUsed = false;
                                    $checkQuery = "SELECT COUNT(*) AS count FROM invoice WHERE idSuratJalan = '$idSuratJalan'";
                                    $checkResult = mysqli_query($conn, $checkQuery);
                                    $checkRow = mysqli_fetch_assoc($checkResult);
                                    if ($checkRow['count'] > 0) {
                                        $isUsed = true; // ID Surat Jalan sudah digunakan
                                    }
                                    if ($isUsed) {
                                        echo "<option value='$idSuratJalan' style='color: grey;' disabled> $idSuratJalan (Sudah Terdaftar) </option>";
                                    } else {
                                        echo "<option value='$idSuratJalan'>$idSuratJalan</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Nama Pelanggan -->
                        <div class="mb-3">
                            <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan" required>
                        </div>

                        <!-- Nama Barang -->
                        <div class="mb-3">
                            <label for="namaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="namaBarang" name="namaBarang" required>
                        </div>

                        <!-- Size Inputs -->
                        <div class="mb-3">
                            <label for="sizeS" class="form-label">Size S</label>
                            <input type="number" class="form-control" id="sizeS" name="sizeS" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="sizeM" class="form-label">Size M</label>
                            <input type="number" class="form-control" id="sizeM" name="sizeM" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="sizeL" class="form-label">Size L</label>
                            <input type="number" class="form-control" id="sizeL" name="sizeL" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="sizeXL" class="form-label">Size XL</label>
                            <input type="number" class="form-control" id="sizeXL" name="sizeXL" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="sizeXXL" class="form-label">Size XXL</label>
                            <input type="number" class="form-control" id="sizeXXL" name="sizeXXL" value="0" required>
                        </div>

                        <!-- Harga per Size -->
                        <div class="mb-3">
                            <label for="hargaS" class="form-label">Harga Size S</label>
                            <input type="number" class="form-control" id="hargaS" name="hargaS" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalS" class="form-label">Total Harga Size S</label>
                            <input type="text" class="form-control" id="totalS" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="hargaM" class="form-label">Harga Size M</label>
                            <input type="number" class="form-control" id="hargaM" name="hargaM" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalM" class="form-label">Total Harga Size M</label>
                            <input type="text" class="form-control" id="totalM" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="hargaL" class="form-label">Harga Size L</label>
                            <input type="number" class="form-control" id="hargaL" name="hargaL" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalL" class="form-label">Total Harga Size L</label>
                            <input type="text" class="form-control" id="totalL" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="hargaXL" class="form-label">Harga Size XL</label>
                            <input type="number" class="form-control" id="hargaXL" name="hargaXL" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalXL" class="form-label">Total Harga Size XL</label>
                            <input type="text" class="form-control" id="totalXL" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="hargaXXL" class="form-label">Harga Size XXL</label>
                            <input type="number" class="form-control" id="hargaXXL" name="hargaXXL" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="totalXXL" class="form-label">Total Harga Size XXL</label>
                            <input type="text" class="form-control" id="totalXXL" readonly>
                        </div>

                        <!-- Total Bayar -->
                        <div class="mb-3">
                            <label for="totalBayar" class="form-label">Total Bayar</label>
                            <input type="text" class="form-control" id="totalBayar" name="totalBayar" readonly>
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
                    Data invoice berhasil ditambahkan.
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
                    <p>Apakah Anda yakin ingin menghapus data invoice ini?</p>
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
                    Data invoice berhasil dihapus.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Invoice -->
    <div class="modal fade" id="editInvoiceModal" tabindex="-1" aria-labelledby="editInvoiceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInvoiceModalLabel">Edit Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editInvoiceForm">
                        <!-- ID Invoice (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editIdInvoice" class="form-label">ID Invoice</label>
                            <input type="text" class="form-control" id="editIdInvoice" name="idInvoice" readonly>
                        </div>

                        <!-- Tanggal Invoice -->
                        <div class="mb-3">
                            <label for="editTanggalInvoice" class="form-label">Tanggal Invoice</label>
                            <input type="date" class="form-control" id="editTanggalInvoice" name="tanggalInvoice"
                                required>
                        </div>

                        <!-- ID Surat Jalan -->
                        <div class="mb-3">
                            <label for="editIdSuratJalan" class="form-label">ID Surat Jalan</label>
                            <input type="text" class="form-control" id="editIdSuratJalan" name="idSuratJalan" required>
                        </div>

                        <!-- Nama Pelanggan (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editNamaPelanggan" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control" id="editNamaPelanggan" name="namaPelanggan"
                                readonly>
                        </div>

                        <!-- Nama Barang (Tidak Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editNamaBarang" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editNamaBarang" name="namaBarang" readonly>
                        </div>

                        <!-- Size Inputs (Semua Bisa Diedit) -->
                        <div class="mb-3">
                            <label for="editSizeS" class="form-label">Size S</label>
                            <input type="number" class="form-control" id="editSizeS" name="sizeS" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeM" class="form-label">Size M</label>
                            <input type="number" class="form-control" id="editSizeM" name="sizeM" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeL" class="form-label">Size L</label>
                            <input type="number" class="form-control" id="editSizeL" name="sizeL" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeXL" class="form-label">Size XL</label>
                            <input type="number" class="form-control" id="editSizeXL" name="sizeXL" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="editSizeXXL" class="form-label">Size XXL</label>
                            <input type="number" class="form-control" id="editSizeXXL" name="sizeXXL" value="0"
                                required>
                        </div>

                        <!-- Harga per Size -->
                        <div class="mb-3">
                            <label for="editHargaS" class="form-label">Harga Size S</label>
                            <input type="number" class="form-control" id="editHargaS" name="hargaS" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalS" class="form-label">Total Harga Size S</label>
                            <input type="text" class="form-control" id="editTotalS" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="editHargaM" class="form-label">Harga Size M</label>
                            <input type="number" class="form-control" id="editHargaM" name="hargaM" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalM" class="form-label">Total Harga Size M</label>
                            <input type="text" class="form-control" id="editTotalM" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="editHargaL" class="form-label">Harga Size L</label>
                            <input type="number" class="form-control" id="editHargaL" name="hargaL" value="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalL" class="form-label">Total Harga Size L</label>
                            <input type="text" class="form-control" id="editTotalL" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="editHargaXL" class="form-label">Harga Size XL</label>
                            <input type="number" class="form-control" id="editHargaXL" name="hargaXL" value="0"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalXL" class="form-label">Total Harga Size XL</label>
                            <input type="text" class="form-control" id="editTotalXL" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="editHargaXXL" class="form-label">Harga Size XXL</label>
                            <input type="number" class="form-control" id="editHargaXXL" name="hargaXXL" value="0"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editTotalXXL" class="form-label">Total Harga Size XXL</label>
                            <input type="text" class="form-control" id="editTotalXXL" readonly>
                        </div>

                        <!-- Total Bayar -->
                        <div class="mb-3">
                            <label for="editTotalBayar" class="form-label">Total Bayar</label>
                            <input type="text" class="form-control" id="editTotalBayar" name="totalBayar" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pesan Sukses Edit -->
    <div class="modal fade" id="successEditModal" tabindex="-1" aria-labelledby="successEditModalLabel"
        aria-hidden="true" 6>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successEditModalLabel">Sukses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data invoice berhasil diperbarui.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Script untuk pengelolaan DataTable dan aksi lainnya -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();

            // Fungsi untuk menghitung total harga per size dan total keseluruhan saat tambah data dan edit data
            function calculateTotal(isEdit = false) {
                var sizeS = parseInt(isEdit ? $('#editSizeS').val() : $('#sizeS').val()) || 0;
                var sizeM = parseInt(isEdit ? $('#editSizeM').val() : $('#sizeM').val()) || 0;
                var sizeL = parseInt(isEdit ? $('#editSizeL').val() : $('#sizeL').val()) || 0;
                var sizeXL = parseInt(isEdit ? $('#editSizeXL').val() : $('#sizeXL').val()) || 0;
                var sizeXXL = parseInt(isEdit ? $('#editSizeXXL').val() : $('#sizeXXL').val()) || 0;

                var hargaS = parseFloat(isEdit ? $('#editHargaS').val() : $('#hargaS').val()) || 0;
                var hargaM = parseFloat(isEdit ? $('#editHargaM').val() : $('#hargaM').val()) || 0;
                var hargaL = parseFloat(isEdit ? $('#editHargaL').val() : $('#hargaL').val()) || 0;
                var hargaXL = parseFloat(isEdit ? $('#editHargaXL').val() : $('#hargaXL').val()) || 0;
                var hargaXXL = parseFloat(isEdit ? $('#editHargaXXL').val() : $('#hargaXXL').val()) || 0;

                // Total per ukuran
                var totalS = sizeS * hargaS;
                var totalM = sizeM * hargaM;
                var totalL = sizeL * hargaL;
                var totalXL = sizeXL * hargaXL;
                var totalXXL = sizeXXL * hargaXXL;

                // Total keseluruhan
                var totalBayar = totalS + totalM + totalL + totalXL + totalXXL;

                // Format mata uang Rupiah
                var formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' });

                // Masukkan nilai ke input dan format menjadi rupiah
                if (isEdit) {
                    $('#editTotalS').val(formatRupiah.format(totalS));
                    $('#editTotalM').val(formatRupiah.format(totalM));
                    $('#editTotalL').val(formatRupiah.format(totalL));
                    $('#editTotalXL').val(formatRupiah.format(totalXL));
                    $('#editTotalXXL').val(formatRupiah.format(totalXXL));
                    $('#editTotalBayar').val(formatRupiah.format(totalBayar));   // Total keseluruhan
                } else {
                    $('#totalS').val(formatRupiah.format(totalS));
                    $('#totalM').val(formatRupiah.format(totalM));
                    $('#totalL').val(formatRupiah.format(totalL));
                    $('#totalXL').val(formatRupiah.format(totalXL));
                    $('#totalXXL').val(formatRupiah.format(totalXXL));
                    $('#totalBayar').val(formatRupiah.format(totalBayar));   // Total keseluruhan
                }
            }

            // Update total otomatis ketika ukuran atau harga diubah saat tambah data
            $('#sizeS, #sizeM, #sizeL, #sizeXL, #sizeXXL, #hargaS, #hargaM, #hargaL, #hargaXL, #hargaXXL').on('input', function () {
                calculateTotal(); // Panggil fungsi untuk tambah data
            });

            // Update total otomatis ketika ukuran atau harga diubah saat edit data
            $('#editSizeS, #editSizeM, #editSizeL, #editSizeXL, #editSizeXXL, #editHargaS, #editHargaM, #editHargaL, #editHargaXL, #editHargaXXL').on('input', function () {
                calculateTotal(true); // Panggil fungsi untuk edit data
            });

            // Fungsi untuk mengambil data surat jalan berdasarkan ID
            $('#idSuratJalan').change(function () {
                var idSuratJalan = $(this).val();

                if (idSuratJalan != "") {
                    $.ajax({
                        url: 'invoice/get_suja_data.php',
                        type: 'GET',
                        data: { idSuratJalan: idSuratJalan },
                        success: function (response) {
                            var data = JSON.parse(response);
                            if (data.error) {
                                alert(data.error);
                            } else {
                                // Generate ID Invoice berdasarkan ID Surat Jalan
                                var idInvoice = "INV" + idSuratJalan.substring(2); // Mengambil angka setelah "SJ" dan mengubahnya menjadi INV
                                $('#idInvoice').val(idInvoice); // Menampilkan ID Invoice

                                // Isi form dengan data dari surat jalan
                                $('#namaPelanggan').val(data.namaPelanggan);
                                $('#namaBarang').val(data.namaBarang);
                                $('#sizeS').val(data.sizeS);
                                $('#sizeM').val(data.sizeM);
                                $('#sizeL').val(data.sizeL);
                                $('#sizeXL').val(data.sizeXL);
                                $('#sizeXXL').val(data.sizeXXL);
                            }
                        },
                        error: function () {
                            alert("Gagal mengambil data Invoice.");
                        }
                    });
                }
            });

            // Insert Data
            $('#invoiceForm').submit(function (e) {
                e.preventDefault(); // Prevent default form submission

                var formData = $(this).serialize(); // Serialize form data

                $.ajax({
                    url: 'invoice/add.php', // PHP script to handle data insertion
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response); // Debugging to check the response
                        if (response.trim() === "success") {
                            $('#successAddModal').modal('show'); // Show success modal
                            $('#invoiceModal').modal('hide'); // Hide the add invoice modal
                            $('#content-area').load('../views/invoice/invoice.php');
                        } else {
                            alert('Gagal menyimpan data: ' + response); // Handle error
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat menyimpan data.'); // Handle AJAX error
                    }
                });
            });

            // Edit Data
            $(document).on('click', '.editBtn', function () {
                var idInvoice = $(this).data('id'); // Ambil ID Invoice dari atribut data-id
                console.log(idInvoice);  // Debugging: cek ID yang diambil
                $.ajax({
                    url: 'invoice/get_inv_data.php', // Ganti URL ke get_inv_data.php
                    type: 'GET',
                    data: { idInvoice: idInvoice },  // Kirimkan idInvoice ke get_inv_data.php
                    success: function (response) {
                        console.log(response);  // Debugging: periksa respons dari server
                        var data = JSON.parse(response); // Parse response as JSON

                        // Isi modal dengan data yang diterima
                        $('#editIdInvoice').val(data.idInvoice);
                        $('#editTanggalInvoice').val(data.tanggal_invoice);
                        $('#editIdSuratJalan').val(data.idSuratJalan);
                        $('#editNamaPelanggan').val(data.nama_pelanggan);
                        $('#editNamaBarang').val(data.nama_barang);
                        $('#editSizeS').val(data.size_s);
                        $('#editSizeM').val(data.size_m);
                        $('#editSizeL').val(data.size_l);
                        $('#editSizeXL').val(data.size_xl);
                        $('#editSizeXXL').val(data.size_xxl);
                        $('#editHargaS').val(data.harga_s);
                        $('#editHargaM').val(data.harga_m);
                        $('#editHargaL').val(data.harga_l);
                        $('#editHargaXL').val(data.harga_xl);
                        $('#editHargaXXL').val(data.harga_xxl);
                        $('#editTotalS').val(data.total_s);
                        $('#editTotalM').val(data.total_m);
                        $('#editTotalL').val(data.total_l);
                        $('#editTotalXL').val(data.total_xl);
                        $('#editTotalXXL').val(data.total_xxl);
                        $('#editTotalBayar').val(data.total_bayar);

                        // Tampilkan modal edit
                        $('#editInvoiceModal').modal('show');
                    },
                    error: function () {
                        alert('Gagal mengambil data.');
                    }
                });
            });

            // Update data invoice
            $('#editInvoiceForm').submit(function (e) {
                e.preventDefault(); // Mencegah refresh halaman

                var formData = $(this).serialize(); // Ambil data form

                $.ajax({
                    url: 'invoice/edit.php', // Kirim ke edit.php untuk melakukan update
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        if (response.trim() === "success") {
                            $('#successEditModal').modal('show');
                            $('#content-area').load('../views/invoice/invoice.php');
                            $('#editInvoiceModal').modal('hide');
                        } else {
                            alert('Gagal mengubah data: ' + response);
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat mengubah data.');
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
                        url: 'invoice/delete.php',
                        type: 'GET',
                        data: { idInvoice: id },
                        success: function (response) {
                            if (response.trim() == "success") {
                                $('#deleteModal').modal('hide');
                                $('#successDeleteModal').modal('show');
                                setTimeout(function () {
                                    $('#content-area').load('../views/invoice/invoice.php');
                                }, 2000);
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

            // Cetak Data
            $('.printBtn').click(function () {
                var idInvoice = $(this).data('id');
                $.ajax({
                    url: 'invoice/cetak_pdf.php',
                    type: 'GET',
                    data: { idInvoice: idInvoice },
                    success: function (response) {
                        console.log(response);  // Debugging untuk melihat response
                        var fileURL = response.trim(); // Mengambil URL PDF
                        if (fileURL) {
                            window.open(fileURL, '_blank'); // Buka PDF di tab baru
                        } else {
                            alert("PDF tidak ditemukan.");
                        }
                    },
                    error: function () {
                        alert("Terjadi kesalahan saat mencetak PDF.");
                    }
                });
            });

        });
    </script>



</body>

</html>