<?php 
require "../../config/fungsi.php";
$id = @$_GET["id"];

if( hapus_monitoring($id) > 0 ){
	echo "<script>
          alert('data berhasil dihapus:');
          document.location.href = '?page=monitoring';
         </script>";
}else{
	echo "
			<script>
				alert('Data gagal dihapus kemungkinan digunakan tabel lain');
				document.location.href = '?page=monitoring';
			</script>
		";
}

?>