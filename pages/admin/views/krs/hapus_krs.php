<?php
include "../../config/fungsi.php";
$id = $_GET['id'];

if ( hapus_krs($id) > 0) {
	echo "
			<script>
				alert('KRS Berhasil Dihapus');
				document.location.href = '?page=krs';
			</script>
		";
}else{
	echo"
			<script>
				alert('KRS Berhasil Dihapus')
				document.location.href = '?page=krs';
			</script>

	";
}


?>