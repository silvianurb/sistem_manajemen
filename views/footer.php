<!-- views/footer.php -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Apakah kamu yakin ingin keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                <a class="btn btn-primary" href="auth/login.php">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="../assets/22/vendor/jquery/jquery.min.js"></script>
<script src="../assets/22/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="../assets/22/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="../assets/22/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="../assets/22/vendor/chart.js/Chart.min.js"></script>

<!-- Page level custom scripts -->
<script src="../assets/22/js/demo/chart-area-demo.js"></script>
<script src="../assets/22/js/demo/chart-pie-demo.js"></script>

<!-- Panggil homecontroller.php untuk JavaScript -->
<?php include('../controllers/HomeController.php'); ?>

</body>
</html>