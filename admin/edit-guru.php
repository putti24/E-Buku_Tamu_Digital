<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM guru WHERE id='$id'");
$guru = mysqli_fetch_assoc($data);

if (isset($_POST['update'])) {

    $nama = $_POST['nama'];
    $bidang = $_POST['bidang'];
    $no_wa = $_POST['no_wa'];

    if ($_FILES['foto']['name'] != "") {
        $foto = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/" . $foto);

        mysqli_query($conn, "UPDATE guru SET 
            nama='$nama',
            bidang='$bidang',
            no_wa='$no_wa',
            foto='$foto'
            WHERE id='$id'");
    } else {
        mysqli_query($conn, "UPDATE guru SET 
            nama='$nama',
            bidang='$bidang',
            no_wa='$no_wa'
            WHERE id='$id'");
    }

    header("Location: data-guru.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Guru</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
</head>

<body class="container p-5">

<h4>Edit Data Guru</h4>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Nama Guru</label>
        <input type="text" name="nama" class="form-control" value="<?= $guru['nama']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Bidang</label>
        <input type="text" name="bidang" class="form-control" value="<?= $guru['bidang']; ?>" required>
    </div>

    <div class="mb-3">
        <label>No WhatsApp</label>
        <input type="text" name="no_wa" class="form-control" value="<?= $guru['no_wa']; ?>" required>
    </div>

    <div class="mb-3">
        <label>Ganti Foto (Opsional)</label>
        <input type="file" name="foto" class="form-control">
    </div>

    <button type="submit" name="update" class="btn btn-primary">
        Update
    </button>

    <a href="data-guru.php" class="btn btn-secondary">
        Kembali
    </a>

</form>

</body>
</html>