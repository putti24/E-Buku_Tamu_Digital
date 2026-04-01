<?php
include '../config/koneksi.php';

$tamu_id = $_POST['tamu_id']; //id tamu
$rating = $_POST['rating'];
$tags = $_POST['tags'];

//menyimpan data review ke dalam tabel review di database
mysqli_query($conn, 
"INSERT INTO review (tamu_id, rating, tags) 
VALUES ('$tamu_id','$rating','$tags')");
