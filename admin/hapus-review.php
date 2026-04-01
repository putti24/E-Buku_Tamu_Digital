<?php
include '../config/koneksi.php';

$id = $_GET['id'];

mysqli_query($conn,
"DELETE FROM review WHERE id='$id'");

header("Location: data-review.php");