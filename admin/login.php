<?php
session_start();
include '../config/koneksi.php';
  
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - E Buku Tamu Digital</title>

  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
  <link rel="stylesheet" href="../assets/vendor/css/core.css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />
  <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />

  <script src="../assets/vendor/js/helpers.js"></script>
  <script src="../assets/js/config.js"></script>

  <style>
    .brand-title {
        font-size: 28px;
        font-weight: 700;
        letter-spacing: 1px;
    }
  </style>
</head>

<body>

<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">

      <div class="card">
        <div class="card-body">

          <!-- Logo -->
        <div class="text-center mb-4">
            <img src="../assets/img/logo.png" width="300">
        </div>

          <h4 class="mb-2 text-center">Selamat Datang 👋</h4>
          <p class="mb-4 text-center">Jelajahi E-Buku Tamu</p>

          <?php if(isset($error)) : ?>
              <div class="alert alert-danger">
                  <?= $error ?>
              </div>
          <?php endif; ?>

          <form method="POST">

            <div class="mb-3">
              <label class="form-label">Username</label>
              <input
                type="text"
                class="form-control"
                name="username"
                placeholder="Masukkan username"
                required
              />
            </div>

            <div class="mb-3 form-password-toggle">
              <label class="form-label">Password</label>
              <div class="input-group input-group-merge">
                <input
                  type="password"
                  class="form-control"
                  name="password"
                  placeholder="••••••••"
                  required
                />
                <span class="input-group-text cursor-pointer">
                  <i class="bx bx-hide"></i>
                </span>
              </div>
            </div>

            <div class="mb-3">
              <button type="submit" name="login" class="btn btn-primary d-grid w-100">
                Sign In
              </button>
            </div>

          </form>

        </div>
      </div>

    </div>
  </div>
</div>

<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/libs/popper/popper.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../assets/vendor/js/menu.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>
