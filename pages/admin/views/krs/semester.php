
<?php 

include "../../../../config/koneksi.php";


$prov_id = $_POST['prov_id'];


$nim = mysqli_query($conn, "SELECT * FROM paket_semester");

echo "<option>- Pilih Semester -</option>";
while($row_nim = mysqli_fetch_array($nim)) {
	echo '<option value="'.$row_nim['id_paket'].'">'.$row_nim['nama_paket'].'</option>' ;
}