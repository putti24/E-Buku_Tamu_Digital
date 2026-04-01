<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "buku_tamu";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// optional: set timezone
date_default_timezone_set("Asia/Jakarta");
?>
