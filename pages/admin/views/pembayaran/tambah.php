<?php 
include "../../../../config/fungsi.php";

if (isset($_POST["tambah"])) {
	$aspek = $_POST['aspek'];

	$query = mysqli_query($conn, "INSERT INTO aspek VALUES ('','$aspek')");
	if ($query) {
		echo "<script>
				alert('Data berhasil ditambahkan')
				window.history.back();
			</script>";
	}else{

		echo ("error ". mysqli_error($conn));
    die;
		echo "<script>
				    alert('Data gagal ditambahkan.');
				    window.history.back();
				</script>";
	}
}

 ?>