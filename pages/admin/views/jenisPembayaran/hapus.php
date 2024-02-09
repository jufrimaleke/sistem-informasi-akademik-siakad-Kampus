<?php 
include "../../config/fungsi.php";
$id = $_GET["id"];

if( hapusJenisPembayaran($id) > 0 ){
	echo "<script>
				    alert('Data berhasil dihapus.');
				    window.history.back();
				</script>";

}else{
	echo ("error ". mysqli_error($conn));
    die;
		echo "<script>
				    alert('Data gagal dihapus.');
				    window.history.back();
				</script>";
}

 ?>