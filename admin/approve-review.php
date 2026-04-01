<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,
"UPDATE review SET status='approved' WHERE id='$id'");

header("Location: data-review.php");