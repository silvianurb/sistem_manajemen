<?php
// homecontroller.php
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Ketika menu "Pelanggan" diklik
        $('#menu-pelanggan').click(function(e) {
            e.preventDefault();  // Mencegah link untuk navigasi
            $('#content-area').load('../views/pelanggan/pelanggan.php');
        });
    });

    // Script untuk menu "Order"
    $(document).ready(function() {
        $('#menu-order').click(function(e) {
            e.preventDefault();  // Mencegah link untuk navigasi
            $('#content-area').load('../views/order/order.php'); 
        });
    });

    // Script untuk menu "Pengguna"
    $(document).ready(function() {
        $('#menu-pengguna').click(function(e) {
            e.preventDefault();  // Mencegah link untuk navigasi
            $('#content-area').load('../views/order/order.php'); 
        });
    });
</script>
<?php
?>