<?php 
include "../../config/fungsi.php";
$nip = $_GET["nip"];

if( hapus_dosen($nip) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=dosen';
			</script>
		";

}else{
	echo "
			<script>
				alert('Gagal di hapus');
				document.location.href = '?page=dosen';
			</script>
		";
}

 ?>