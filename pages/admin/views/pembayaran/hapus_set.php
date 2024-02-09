<?php 
include "../../config/fungsi.php";
$id_set = $_GET["id_set"];

if( hapus_setPembayaran($id_set) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=pembayaran';
			</script>
		";

}else{
	echo "
			<script>
				alert('Data gagal dihapus kemungkinan digunakan tabel lain');
				document.location.href = '?page=pembayaran';
			</script>
		";
}

 ?>