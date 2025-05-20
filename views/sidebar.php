<!-- views/sidebar.php -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-tshirt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Gemilang</div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Beranda</span></a>
    </li>
    <?php if ($_SESSION['role'] == 'admin'): ?>
        <hr class="sidebar-divider">

        <div class="sidebar-heading">Pesanan</div>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-pelanggan">
                <i class="fas fa-fw fa-users"></i>
                <span>Pelanggan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-order">
                <i class="fas fa-fw fa-shopping-cart"></i>
                <span>Order</span>
            </a>
        </li>
    <?php endif; ?>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Manajemen Dokumen</div>

    <?php if ($_SESSION['role'] == 'admin'): ?>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-suratjalan">
                <i class="fas fa-fw fa-truck"></i>
                <span>Surat Jalan</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-invoice">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Invoice</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-bahanbaku">
                <i class="fas fa-fw fa-boxes"></i>
                <span>Bahan Baku</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-pengguna">
                <i class="fas fa-fw fa-users-cog"></i>
                <span>Pengguna</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'manajer'): ?>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-laporan">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Laporan</span>
            </a>
        </li>
    <?php endif; ?>

    <?php if ($_SESSION['role'] == 'petugas'): ?>
        <li class="nav-item">
            <a class="nav-link" href="#" id="menu-distribusi">
                <i class="fas fa-fw fa-truck"></i>
                <span>Tugas Distribusi</span>
            </a>
        </li>
    <?php endif; ?>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>