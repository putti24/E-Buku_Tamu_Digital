<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// ambil data foto dulu
$data = mysqli_query($conn, "SELECT foto FROM guru WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if ($row['foto'] != "default.png") {
    unlink("../uploads/" . $row['foto']);
}

mysqli_query($conn, "DELETE FROM guru WHERE id='$id'");

header("Location: data-guru.php");