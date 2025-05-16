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
    // Update query to fetch data from the 'invoice' table
    $query = "SELECT idInvoice, tanggal_invoice, nama_pelanggan, total_bayar FROM invoice";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal: " . mysqli_error($conn));
    }
    ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Data Laporan</h6>
        </div>
        <div class="card-body">
            <!-- Tambah Data Button placed here -->
            <div class="row">
                <div class="col-lg-3">
                    <input name="txtTglAwal" type="date" class="form-control" value="<?php echo $awalTgl; ?>"
                        size="10" />
                </div>
                <div class="col-lg-3">
                    <input name="txtTglAkhir" type="date" class="form-control" value="<?php echo $akhirTgl; ?>"
                        size="10" />
                </div>
                <div class="mb-3">
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">Tampilkan</button>
                </div>
                <div class="col-lg-3">
                    <!-- Add the Print button here -->
                    <button class="btn btn-info" id="printBtn">Cetak</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID Invoice</th>
                                <th>Tanggal Invoice</th>
                                <th>Nama Pelanggan</th>
                                <th>Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td><?php echo $row['idInvoice']; ?></td>
                                    <td><?php echo $row['tanggal_invoice']; ?></td>
                                    <td><?php echo $row['nama_pelanggan']; ?></td>
                                    <td><?php echo "Rp " . number_format($row['total_bayar'], 0, ',', '.'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
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
            });
        </script>

</body>

</html>