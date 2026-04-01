<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// SEARCH
$keyword = "";
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $query = mysqli_query($conn, "SELECT * FROM guru 
        WHERE nama LIKE '%$keyword%' 
        OR bidang LIKE '%$keyword%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr"
data-theme="theme-default" data-assets-path="../assets/"
data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <title>Data Guru - E Buku Tamu</title>

    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
</head>

<body>
<?php
include 'layouts/header.php';
include 'layouts/sidebar.php';
?>

<div class="page-breadcrumb mb-3">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                Data Guru
            </li>
        </ol>
    </nav>
</div>

<!-- CONTENT -->
<div class="content-wrapper">
<div class="container-xxl flex-grow-1 container-p-y">

<h4 class="fw-bold mb-4">Data Guru</h4>

<div class="d-flex justify-content-between mb-4">
    <a href="tambah-guru.php" class="btn btn-primary">
        <i class="bx bx-plus"></i> Tambah Guru
    </a>

    <form method="GET" class="d-flex">
        <input type="text" name="search" class="form-control"
               placeholder="Cari guru..." value="<?= $keyword ?>">
        <button class="btn btn-outline-primary ms-2">
            <i class="bx bx-search"></i>
        </button>
    </form>
</div>

<div class="row">

<?php while ($guru = mysqli_fetch_assoc($query)) : ?>

<div class="col-md-4 mb-4">
    <div class="card text-center p-3">

        <img src="../uploads/<?= $guru['foto'] ?: 'default.png'; ?>"
             class="rounded-circle mx-auto mb-3"
             width="100" height="100"
             style="object-fit:cover;">

        <h5 class="fw-bold"><?= $guru['nama']; ?></h5>
        <p class="text-muted mb-1"><?= $guru['bidang']; ?></p>
        <p class="text-muted"><?= $guru['no_wa']; ?></p>

        <div class="d-flex justify-content-center gap-2">
            <a href="edit-guru.php?id=<?= $guru['id']; ?>"
               class="btn btn-sm btn-primary">
               Edit
            </a>

            <a href="hapus-guru.php?id=<?= $guru['id']; ?>"
               class="btn btn-sm btn-danger"
               onclick="return confirm('Yakin hapus?')">
               Hapus
            </a>
        </div>

    </div>
</div>

<?php endwhile; ?>

</div>

</div>
</div>

</div>
</div>

<script src="../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../assets/vendor/js/bootstrap.js"></script>
<script src="../assets/js/main.js"></script>

</body>
<?php include 'layouts/footer.php'; ?>
</html>