<?php 
// include "../../config/fungsi.php";
$id = $_GET["id_materi"];

if( hapus_materi($id) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=materi';
			</script>
		";

}else{
	echo "
			<script>
				alert('Gagal di hapus');
				document.location.href = '?page=materi';
			</script>
		";
}

 ?>