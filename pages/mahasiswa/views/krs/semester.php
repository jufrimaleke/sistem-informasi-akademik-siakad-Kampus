
<?php 

include "../../../../config/koneksi.php";


$prov_id = $_POST['prov_id'];

$nim = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id_jurusan = $prov_id");

echo "<option>".$prov_id."</option>";

while($row_nim = mysqli_fetch_array($nim)) {
	echo '<option value="'.$row_nim['nim'].'">'.$row_nim['nim'].' - '.$row_nim['nama'].'</option>' ;
}
