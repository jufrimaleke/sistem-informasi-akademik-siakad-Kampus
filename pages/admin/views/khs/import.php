<?php
if (!isset($_SESSION))session_start();
// Load file koneksi.php
include "../../../../config/fungsi.php";

$id_krs = @$_SESSION['id_jadwal'];

if(isset($_POST['import'])){ // Jika user mengklik tombol Import

	$nama_file_baru = 'data.xlsx';

	// Load librari PHPExcel nya
	require_once '../../../../assets/PHPExcel/PHPExcel.php';

	$excelreader = new PHPExcel_Reader_Excel2007();
	$loadexcel = $excelreader->load('../../../../assets/tmp/'.$nama_file_baru); // Load file excel yang tadi diupload ke folder tmp
	$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

	$numrow = 1;
	foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
		$no 	 = $row['A'];
	    $id_khs  = $row['B'];
	    $nim     = $row['C']; // Ambil data NIS
	    $nama    = $row['D']; // Ambil data nama
	    $n_tugas = $row['E']; // Ambil data jenis kelamin
	    $n_uts   = $row['F']; // Ambil data telepon
	    $n_uas   = $row['G']; // Ambil data alamat
	    $n_akhir = $row['H'];
	    $n_huruf = $row['I'];

		// Cek jika semua data tidak diisi
        if(empty($no) && empty($id_khs) && empty($nim) && empty($nama) && empty($n_tugas) && empty($n_uts) && empty($n_uas) && empty($n_akhir) && empty($n_huruf))
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if($numrow > 1){
			// Buat query Insert
			$query = "UPDATE khs SET
				nilai_tgs 	= '$n_tugas',
				nilai_uts   = '$n_uts',
				nilai_uas   = '$n_uas',
				nilai_akhir = '$n_akhir',
				nilai_huruf = '$n_huruf'
				WHERE id_khs= $id_khs";

			// Eksekusi $query
			mysqli_query($conn, $query);
		}

		$numrow++; // Tambah 1 setiap kali looping
	}
}

echo "
<script>
    alert('Nilai berhasil diunggah.');
    window.location.href = document.referrer;
</script>


";

?>

