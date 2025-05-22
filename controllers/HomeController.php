<?php
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#menu-pelanggan').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/pelanggan/pelanggan.php');
        });
    });

    // Script untuk menu "Order"
    $(document).ready(function () {
        $('#menu-order').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/order/order.php');
        });
    });

    // Script untuk menu "Surat Jalan"
    $(document).ready(function () {
        $('#menu-suratjalan').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/suratjalan/suratjalan.php');
        });
    });

    // Script untuk menu "Invoice"
    $(document).ready(function () {
        $('#menu-invoice').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/invoice/invoice.php');
        });
    });

    // Script untuk menu "Bahan Baku"
    $(document).ready(function () {
        $('#menu-bahanbaku').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/bahanbaku/bahanbaku.php');
        });
    });

    // Script untuk menu "Pengguna"
    $(document).ready(function () {
        $('#menu-pengguna').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/pengguna/pengguna.php');
        });
    });

    // Script untuk menu "Laporan"
    $(document).ready(function () {
        $('#menu-laporan').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/laporan/laporan.php');
        });
    });

    // Script untuk menu "Distribusi"
    $(document).ready(function () {
        $('#menu-distribusi').click(function (e) {
            e.preventDefault();
            $('#content-area').load('../views/distribusi/distribusi.php');
        });
    });
</script>
<?php
?>