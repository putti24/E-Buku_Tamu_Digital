<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// ambil data guru untuk dropdown
$guru = mysqli_query($conn, "SELECT * FROM guru ORDER BY nama ASC");

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $instansi = $_POST['instansi'];
    $no_hp = $_POST['no_hp'];
    $guru_id = $_POST['guru_id'];
    $keperluan = $_POST['keperluan'];

    mysqli_query($conn, "INSERT INTO tamu 
        (nama, instansi, no_hp, guru_id, keperluan) 
        VALUES 
        ('$nama','$instansi','$no_hp','$guru_id','$keperluan')");

    header("Location: data-tamu.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tamu</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
</head>

<body class="container p-5">

<h4>Input Buku Tamu</h4>

<form method="POST">

    <div class="mb-3">
        <label>Nama Tamu</label>
        <input type="text" name="nama" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Instansi</label>
        <input type="text" name="instansi" class="form-control">
    </div>

    <div class="mb-3">
        <label>No HP</label>
        <input type="text" name="no_hp" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Menemui</label>
        <select name="guru_id" class="form-control" required>
            <option value="">-- Pilih Guru --</option>
            <?php while($g = mysqli_fetch_assoc($guru)) : ?>
                <option value="<?= $g['id']; ?>">
                    <?= $g['nama']; ?> - <?= $g['bidang']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Keperluan</label>
        <textarea name="keperluan" class="form-control" required></textarea>
    </div>

    <button type="submit" name="simpan" class="btn btn-primary">
        Simpan
    </button>

    <a href="data-tamu.php" class="btn btn-secondary">
        Kembali
    </a>

</form>

</body>
</html>