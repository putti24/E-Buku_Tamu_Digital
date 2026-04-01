<?php
include '../config/koneksi.php';

$tamu_id = $_POST['tamu_id']; //id tamu (fk dari tabel tamu)
$rating = $_POST['rating']; //nilai rating
$tags = $_POST['tags']; //tag review

//menyimpan data review ke dalam tabel review di database
mysqli_query($conn, 
"INSERT INTO review (tamu_id, rating, tags) 
VALUES ('$tamu_id','$rating','$tags')");
