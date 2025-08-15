<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../../assets/css/login/style.css">
  <link rel="icon" type="image/png" href="../assets/images/logo_cv.jpeg">
  <title>GEMILANG</title>
</head>

<body>
  <section class="ftco-section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10">
          <div class="wrap d-md-flex">
            <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
              <div class="text w-100">
                <h2>CV KARYA KALANI GEMILANG</h2>
                <p>Sistem Manajemen Pesanan dan Produksi</p>
              </div>
            </div>
            <div class="login-wrap p-4 p-lg-5">
              <div class="d-flex">
                <div class="w-100">
                  <h3 class="mb-4">Selamat Datang</h3>
                </div>
              </div>

              <!-- Menampilkan pesan error jika ada -->
              <?php
              if (isset($_SESSION['error_message'])) {
                echo "<div style='color: red; font-weight: bold;'>" . $_SESSION['error_message'] . "</div>";
                unset($_SESSION['error_message']); // Hapus pesan error setelah ditampilkan
              }
              ?>

              <!-- Form login -->
              <form action="../../controllers/AuthController.php" method="POST" class="signin-form">
                <div class="form-group mb-3">
                  <label class="label" for="username">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="form-group mb-3">
                  <label class="label" for="password">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    <div class="input-group-append">
                      <span class="input-group-text" id="togglePassword">
                        <i class="fa fa-eye"></i>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary submit px-3">Masuk</button>
                </div>
                <div class="form-group d-md-flex justify-content-center">
                  <div class="w-50 text-center">
                    <a style="font-size: 12px;">Jika belum memiliki akun, silakan hubungi admin</a>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="../../assets/js/jquery.min.js"></script>
  <script src="../../assets/js/popper.js"></script>
  <script src="../../assets/js/bootstrap.min.js"></script>
  <script src="../../assets/js/main.js"></script>

  <script>
    // Toggle Password visibility
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function (e) {
      // Toggle the type attribute
      const type = password.type === "password" ? "text" : "password";
      password.type = type;

      // Toggle the eye icon
      this.innerHTML = type === "password" ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>';
    });
  </script>
</body>

</html>
