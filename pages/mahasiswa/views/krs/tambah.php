<?php 
require "../../config/fungsi.php";
// $dosen = mysqli_query($conn, "SELECT * FROM dosen");

//cek apakah tombol submit sudah ditekan atau belum
if(isset($_POST["submit"])){

	//cek apakah    data berhasil ditambahkan atau tidak
	if(tambah_krs($_POST) > 0 ){
		echo "
			<script>
				alert('data berhasil ditambahkan:');
				document.location.href = '?page=krs';
			</script>
		";
	} else {
		echo ("error ". mysqli_error($conn));
    die;
		echo "
		 	<script>
				alert('data gagal ditambahkan:');
				document.location.href = '?page=krs';
			</script>
		";
	}

}
?>