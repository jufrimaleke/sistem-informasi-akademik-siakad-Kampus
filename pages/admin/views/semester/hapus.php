<?php 
include "../../config/fungsi.php";
$id_mk = $_GET["id_mk"];

if( hapus_mk($id_mk) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=mk';
			</script>
		";

}else{
	echo "
			<script>
				alert('Gagal di hapus');
				document.location.href = '?page=mk';
			</script>
		";
}

 ?>