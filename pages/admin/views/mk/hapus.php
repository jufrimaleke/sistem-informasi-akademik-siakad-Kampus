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
				alert('Data gagal dihapus kemungkinan digunakan tabel lain');
				document.location.href = '?page=mk';
			</script>
		";
}

 ?>