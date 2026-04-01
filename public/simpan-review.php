<?php
include '../config/koneksi.php';

$tamu_id = $_POST['tamu_id'];
$rating = $_POST['rating'];
$tags = $_POST['tags'];

mysqli_query($conn, 
"INSERT INTO review (tamu_id, rating, tags) 
VALUES ('$tamu_id','$rating','$tags')");