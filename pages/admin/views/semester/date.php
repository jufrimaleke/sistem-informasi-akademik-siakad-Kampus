<?php 

if (isset($_POST['ubah'])) {
	$id = $_POST['id_semester'];
	$deadline = $_POST['deadline'];


	$query_ubah = mysqli_query($conn,"UPDATE semester SET
					id_semester = '$id',
					deateline_time = '$deadline'
					WHERE id_semester = '$id_semester'");

	if ($query_ubah) {
		echo "<script>alert('Berhasil diubah');
		window.history.back</script>";
	}else{
		echo "<script>alert('Gagal diubah');
		window.history.back</script>"; . mysqli_error($conn);
	}
}
?>