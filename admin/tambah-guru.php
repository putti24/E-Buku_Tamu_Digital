<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $bidang = $_POST['bidang'];
    $no_wa = $_POST['no_wa'];

    // Upload Foto
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    if ($foto != "") {
        move_uploaded_file($tmp, "../uploads/" . $foto);
    } else {
        $foto = "default.png";
    }

    mysqli_query($conn, "INSERT INTO guru (nama, bidang, no_wa, foto) 
                         VALUES ('$nama','$bidang','$no_wa','$foto')");

    header("Location: data-guru.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Guru</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
</head>

<body class="container p-5">

<h4 class="mb-4">Tambah Data Guru</h4>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Nama Guru</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Bidang</label>
        <input type="text" name="bidang" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>No WhatsApp</label>
        <input type="text" name="no_wa" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Foto Guru</label>
        <input type="file" name="foto" class="form-control">
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">
        Simpan
    </button>

    <a href="data-guru.php" class="btn btn-secondary">
        Kembali
    </a>

</form>

</body>
</html>