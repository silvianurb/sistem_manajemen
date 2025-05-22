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

    $query = "SELECT idInvoice, tanggal_invoice, nama_barang, nama_pelanggan, total_bayar FROM invoice";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Laporan Invoice</h6>
        </div>
        <div class="card-body">
            <form method="get" id="bulanForm">
                <div class="row mb-3">
                    <!-- Dropdown bulan -->
                    <div class="col-md-3">
                        <select name="month" id="month" class="form-control">
                            <option value="1" <?php echo (isset($_GET['month']) && $_GET['month'] == 1) ? 'selected' : ''; ?>>Januari</option>
                            <option value="2" <?php echo (isset($_GET['month']) && $_GET['month'] == 2) ? 'selected' : ''; ?>>Februari</option>
                            <option value="3" <?php echo (isset($_GET['month']) && $_GET['month'] == 3) ? 'selected' : ''; ?>>Maret</option>
                            <option value="4" <?php echo (isset($_GET['month']) && $_GET['month'] == 4) ? 'selected' : ''; ?>>April</option>
                            <option value="5" <?php echo (isset($_GET['month']) && $_GET['month'] == 5) ? 'selected' : ''; ?>>Mei</option>
                            <option value="6" <?php echo (isset($_GET['month']) && $_GET['month'] == 6) ? 'selected' : ''; ?>>Juni</option>
                            <option value="7" <?php echo (isset($_GET['month']) && $_GET['month'] == 7) ? 'selected' : ''; ?>>Juli</option>
                            <option value="8" <?php echo (isset($_GET['month']) && $_GET['month'] == 8) ? 'selected' : ''; ?>>Agustus</option>
                            <option value="9" <?php echo (isset($_GET['month']) && $_GET['month'] == 9) ? 'selected' : ''; ?>>September</option>
                            <option value="10" <?php echo (isset($_GET['month']) && $_GET['month'] == 10) ? 'selected' : ''; ?>>Oktober</option>
                            <option value="11" <?php echo (isset($_GET['month']) && $_GET['month'] == 11) ? 'selected' : ''; ?>>November</option>
                            <option value="12" <?php echo (isset($_GET['month']) && $_GET['month'] == 12) ? 'selected' : ''; ?>>Desember</option>
                        </select>
                    </div>

                    <!-- Tombol Cetak Laporan -->
                    <div class="col-md-3">
                        <button type="button" id="cetakLaporan" class="btn btn-success w-80">Cetak Laporan</button>
                    </div>
                </div>
            </form>

            <!-- Tabel untuk menampilkan data -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Invoice</th>
                            <th>Tanggal Invoice</th>
                            <th>Nama Barang</th>
                            <th>Nama Pelanggan</th>
                            <th>Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceData">
                        <?php
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['idInvoice']; ?></td>
                                    <td><?php echo $row['tanggal_invoice']; ?></td>
                                    <td><?php echo $row['nama_barang']; ?></td>
                                    <td><?php echo $row['nama_pelanggan']; ?></td>
                                    <td><?php echo "Rp " . number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data untuk ditampilkan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Pesan - Tidak ada data untuk bulan tersebut -->
    <div class="modal fade" id="noDataModal" tabindex="-1" aria-labelledby="noDataModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noDataModalLabel">Informasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tidak ada data laporan untuk bulan yang dipilih.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables Script Initialization -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            // Ketika tombol "Cetak Laporan" ditekan
            $('#cetakLaporan').click(function () {
                var month = $('#month').val();
                $.ajax({
                    url: 'laporan/cetak_laporan.php', 
                    type: 'GET',
                    data: { month: month },
                    success: function (response) {
                        if (response == 'no_data') {
                            $('#noDataModal').modal('show');
                        } else {
                            var pdfWindow = window.open();
                            pdfWindow.document.write('<iframe src="' + response + '" frameborder="0" width="100%" height="100%"></iframe>');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>