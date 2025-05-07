<!-- views/dashboard.php -->
<?php
session_start();
include_once('../config/config.php');

$query = "SELECT SUM(total_bayar) AS total_pendapatan FROM invoice";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = mysqli_fetch_assoc($result);
    $totalPendapatan = $data['total_pendapatan']; 

    // Query untuk menghitung jumlah invoice
    $query_invoice = "SELECT COUNT(*) AS total_invoice FROM invoice";
    $result_invoice = mysqli_query($conn, $query_invoice);
    $data_invoice = mysqli_fetch_assoc($result_invoice);
    $totalInvoice = $data_invoice['total_invoice'];  

    // Query untuk menghitung jumlah surat jalan
    $query_surat_jalan = "SELECT COUNT(*) AS total_surat_jalan FROM suratjalan";
    $result_surat_jalan = mysqli_query($conn, $query_surat_jalan);
    $data_surat_jalan = mysqli_fetch_assoc($result_surat_jalan);
    $totalSuratJalan = $data_surat_jalan['total_surat_jalan'];  

    // Query untuk menghitung jumlah pesanan aktif
    $query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan";
    $result_pesanan = mysqli_query($conn, $query_pesanan);
    $data_pesanan = mysqli_fetch_assoc($result_pesanan);
    $totalPesanan = $data_pesanan['total_pesanan'];
} else {
    // Jika query gagal, beri tahu errornya
    echo "Error executing query: " . mysqli_error($conn);
}
?>

<?php include('header.php'); ?>

<div id="wrapper">
    <?php include('sidebar.php'); ?>

    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <h1 class="text-center" style="font-size: 30px; font-weight: bold; padding: 10px 0; margin-top: 10px;">
                    CV KARYA KALANI GEMILANG
                </h1>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item no-arrow">
                        <button class="btn btn-link nav-link" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                        </button>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <div id="content-area">
                    <!-- Display welcome message -->
                    <div class="alert alert-info">
                        <strong>Selamat datang kembali, <?php echo $_SESSION['namaUser']; ?>!</strong>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Pendapatan
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?php echo number_format($totalPendapatan, 0, ',', '.'); ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Invoice
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalInvoice; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Surat Jalan
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalSuratJalan; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-truck fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pesanan
                                                </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalPesanan; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Row -->

                    <!-- Scroll to Top Button-->
                    <a class="scroll-to-top rounded" href="#page-top">
                        <i class="fas fa-angle-up"></i>
                    </a>
                </div>
            </div>

            <?php include('footer.php'); ?>