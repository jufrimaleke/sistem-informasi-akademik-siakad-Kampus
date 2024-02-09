<?php 
require "../../config/fungsi.php";
$id = @$_GET["id_jurusan"];

if(hapus_prodi($id) > 0 ){
	echo "<script>
          alert('data berhasil dihapus:');
          document.location.href = '?page=prodi';
         </script>";
}else {
	var_dump($_GET);
	 echo "Error deleting record: " . $conn->error; die;
    echo "<script>
           alert('data gagal dihapus:');
           document.location.href = '?page=prodi';
          </script>";
  }

?>