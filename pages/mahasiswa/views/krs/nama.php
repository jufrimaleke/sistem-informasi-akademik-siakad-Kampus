<?php 

include "../../../../config/koneksi.php";


$nim = $_POST['nim'];

$nama = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id_jurusan = $nim");


while($row_nama = mysqli_fetch_array($nama)) {
	//echo '<input value="'.$row_nama['nama'].'">' ;
	var_dump($nama);
}
