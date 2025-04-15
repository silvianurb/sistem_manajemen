<?php
// homecontroller.php
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
</script>
<?php
?>