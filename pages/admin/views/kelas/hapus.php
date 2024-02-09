<?php 
require "../../config/fungsi.php";
$id = @$_GET["id_kelas"];

if(hapus_kelas($id) > 0 ){
	echo "<script>
          alert('data berhasil dihapus:');
          document.location.href = '?page=kelas';
         </script>";
}else{
	echo "
			<script>
				alert('Data gagal dihapus kemungkinan digunakan tabel lain');
				document.location.href = '?page=kelas';
			</script>
		";
}

?>