
<?php 

include "../../../../config/koneksi.php";


$prov_id = $_POST['prov_id'];

$nim = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = $prov_id");


while($row_nim = mysqli_fetch_array($nim)) {
	echo '<option value="'.$row_nim['nim'].'">'.$row_nim['nama'].'</option>' ;
}
