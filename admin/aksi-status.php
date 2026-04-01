<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$status = $_GET['status'];

mysqli_query($conn, "UPDATE tamu SET status='$status' WHERE id='$id'");

header("Location: data-tamu.php");