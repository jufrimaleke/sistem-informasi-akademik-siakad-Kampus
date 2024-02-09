<?php 
 include "../../config/fungsi.php";

$id = $_GET['id_semester'];	

$cari = mysqli_query($conn, "SELECT * FROM semester WHERE kuesioner = '1'");
while($row = mysqli_fetch_assoc($cari)){
		$coba = $row['id_semester'];
	}

$query1 = "UPDATE semester SET kuesioner = '0' WHERE id_semester = $coba";
mysqli_query($conn, $query1);

$query = "UPDATE semester SET kuesioner = '1' WHERE id_semester = $id";
mysqli_query($conn, $query);

// echo $_GET['id_semester'];
 ?>