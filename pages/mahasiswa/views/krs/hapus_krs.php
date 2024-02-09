<?php 
$id = $_GET['id_khs'];

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