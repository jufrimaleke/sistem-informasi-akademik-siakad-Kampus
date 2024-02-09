<?php 
include "../../config/fungsi.php";
$id_mk = $_GET["id_jadwal"];

if( hapus_jadwal($id_mk) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=jadwal';
			</script>
		";

}else{
	echo "
			<script>
				alert('Gagal di hapus / Kemungkinan sudah digunakan pada data lain');
				document.location.href = '?page=jadwal';
			</script>
		";
}

 ?>