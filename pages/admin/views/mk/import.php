<?php
if (!isset($_SESSION))session_start();
// Load file koneksi.php
include "../../../../config/fungsi.php";

// $id_krs = @$_SESSION['id_jadwal'];

if(isset($_POST['import'])){ // Jika user mengklik tombol Import

	$nama_file_baru = 'data.xlsx';

	// Load librari PHPExcel nya
	require_once '../../../../assets/PHPExcel/PHPExcel.php';

	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('../../../../assets/tmp/mk/'.$nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

	$sql = "INSERT INTO mata_kuliah (id_mk, kode_mk, nama_mk, sks, id_paketSemester, id_jurusan) VALUES (?, ?, ?, ?, ?, ?)";
	$stmt = $conn->prepare($sql);

	for ($i = 2; $i <= count($sheet); $i++) {
	    $kode_mk 			= htmlspecialchars($sheet[$i]['B']);
	    $nama_mk 			= htmlspecialchars($sheet[$i]['C']);
	    $sks 				= htmlspecialchars($sheet[$i]['D']);
	    $paket_semester 	= htmlspecialchars($sheet[$i]['E']);
	    $jurusan 			= htmlspecialchars($sheet[$i]['F']);

	    if ($jurusan != 9 && $jurusan != 10) {
	        echo "<script>
	            alert('Data Id Prodi salah.');
	            window.location.href = document.referrer;
	        </script>";
	        exit(); // Berhenti jika data tidak valid
	    }else{

	    // Bind parameters dan eksekusi query
	    $id_mk = ''; // Atur nilai id_mk sesuai kebutuhan, atau gunakan AUTO_INCREMENT
	    $stmt->bind_param("sssiii", $id_mk, $kode_mk, $nama_mk, $sks, $paket_semester, $jurusan);
	    $stmt->execute();

		// Berhasil jika mencapai sini
		echo "
		    <script>
		        alert('Data berhasil diunggah.');
		        window.location.href = document.referrer;
		    </script>
		    ";
		}

	}
}
?>
