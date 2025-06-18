<!-- views/dashboard.php -->
<?php
session_start();
include_once('../config/config.php');
check_login();

// Query untuk menghitung total pendapatan
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

    // Query untuk menghitung jumlah pesanan
    $query_pesanan = "SELECT COUNT(*) AS total_pesanan FROM pesanan";
    $result_pesanan = mysqli_query($conn, $query_pesanan);
    $data_pesanan = mysqli_fetch_assoc($result_pesanan);
    $totalPesanan = $data_pesanan['total_pesanan'];

    // Query untuk menghitung jumlah pesanan yang statusnya pending
    $query_pesanan_pending = "SELECT COUNT(*) AS total_pesanan_pending FROM pesanan WHERE status = 'pending'";
    $result_pesanan_pending = mysqli_query($conn, $query_pesanan_pending);
    $data_pesanan_pending = mysqli_fetch_assoc($result_pesanan_pending);
    $totalPesananPending = $data_pesanan_pending['total_pesanan_pending'];

    // Query untuk menghitung jumlah surat jalan yang status pengirimannya 'Dikirim'
    $query_surat_jalan_dikirim = "SELECT COUNT(*) AS total_surat_jalan_dikirim FROM suratjalan WHERE status_pengiriman = 'Dikirim'";
    $result_surat_jalan_dikirim = mysqli_query($conn, $query_surat_jalan_dikirim);
    $data_surat_jalan_dikirim = mysqli_fetch_assoc($result_surat_jalan_dikirim);
    $totalSuratJalanDikirim = $data_surat_jalan_dikirim['total_surat_jalan_dikirim'];
} else {
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
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <h1 class="text-center" style="font-size: 24px; font-weight: bold; padding: 10px 0; margin-top: 10px;">
                    Sistem Manajemen Pesanan dan Produksi
                </h1>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 medium">Halo,
                                <?php echo $_SESSION['namaUser']; ?></span>
                            <!-- Tambahkan simbol untuk memperjelas dropdown -->
                            <i class="fas fa-caret-down ml-2"></i>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                                data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <div id="content-area">
                    <!-- Content Row -->
                    <div class="row">
                        <!-- Informasi Total Pendapatan -->
                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manajer'): ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                    Total Pendapatan
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp.
                                                    <?php echo number_format($totalPendapatan, 0, ',', '.'); ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Informasi Total Invoice -->
                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manajer'): ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Invoice
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $totalInvoice; ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Informasi Total Surat Jalan -->
                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manajer' || $_SESSION['role'] == 'petugas'): ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Surat Jalan
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $totalSuratJalan; ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-truck fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Informasi Total Pesanan -->
                        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manajer'): ?>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-left-warning shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                    Pesanan
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <?php echo $totalPesanan; ?>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Notifications Section -->
                    <div class="container-fluid mt-4">
                        <?php if ($totalPesananPending > 0): ?>
                            <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                                <span>
                                    <strong><?php echo $totalPesananPending; ?> Pesanan Perlu Segera Diproses...</strong>
                                </span>
                                <i class="fas fa-exclamation-triangle text-warning"></i>
                            </div>
                        <?php endif; ?>

                        <?php if ($totalSuratJalanDikirim > 0): ?>
                            <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                                <span>
                                    <strong><?php echo $totalSuratJalanDikirim; ?> Barang yang Sedang dalam Proses
                                        Pengiriman Belum Sampai ke Pelanggan...</strong>
                                </span>
                                <i class="fas fa-truck text-danger"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

            <?php include('footer.php'); ?>