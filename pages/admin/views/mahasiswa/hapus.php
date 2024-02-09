<?php 
include "../../config/fungsi.php";
$nim = $_GET["nim"];

if( hapus_mahasiswa($nim) > 0 ){
	echo "
			<script>
				alert('Berhasil di hapus');
				document.location.href = '?page=mahasiswa';
			</script>
		";

}else{
	echo "
			<script>
				alert('Data gagal dihapus kemungkinan digunakan tabel lain');
				document.location.href = '?page=mahasiswa';
			</script>
		";
}

 ?>