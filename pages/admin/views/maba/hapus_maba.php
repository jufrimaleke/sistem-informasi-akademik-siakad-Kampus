<?php 
include "../../config/fungsi.php";
$no_pendaftaran = $_GET["no_pendaftaran"];

if( hapus_maba($no_pendaftaran) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=maba';
			</script>
		";

}else{
	echo "
			<script>
				alert('Data gagal dihapus');
				document.location.href = '?page=maba';
			</script>
		";
}

 ?>