<?php 
 if (!isset($_SESSION))session_start();
include "../../../../config/fungsi.php";
  
include "../../../../assets/PHPExcel/PHPExcel.php";

$excel = new PHPExcel();

  $id_krs = @$_SESSION['id_krs'];

  $khs = mysqli_query($conn, "SELECT * FROM khs
           INNER JOIN jadwal ON khs.id_krs = jadwal.id_krs
           INNER JOIN mahasiswa ON khs.nim = mahasiswa.nim
           WHERE khs.id_krs = $id_krs");

  $mk   = mysqli_query($conn, "SELECT * FROM khs
           INNER JOIN mata_kuliah ON khs.id_mk = mata_kuliah.id_mk
           WHERE khs.id_krs = $id_krs");

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php
  while ($row = mysqli_fetch_assoc($khs)) {
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Kelas Peserta.xlsx"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

	?>
	
	<table border="1">
		    <tr>
          <th>No.</th>
          <th hidden="true">Id KHS</th>		      
          <th>NIM</th>
          <th>Nama</th>
          <th>Nilai Tugas</th>
          <th>Nilai UTS</th>
          <th>Nilai UAS</th>
          <th>Nilai Akhir</th>
          <th>Nilai Huruf</th>
		    </tr>
        <?php $no = 1; ?>
        <?php  ?>
        <tr>  
          <td align="center"><?= $no; ?></td>        
          <td hidden="true" align="center"><?= $row["id_khs"] ?></td>          
          <td align="center"><?= $row["nim"] ?></td>
          <td align="center"><?= $row["nama"] ?></td>
          <td align="center"><?= $row["nilai_tgs"] ?></td>
          <td align="center"><?= $row["nilai_uts"] ?></td>
          <td align="center"><?= $row["nilai_uas"] ?></td>
          <td align="center"><?= $row["nilai_akhir"] ?></td>
          <td align="center"><?= $row["nilai_huruf"] ?></td>
        </tr>  
        <?php $no++; ?>
        <?php } ?>
	</table>
<?php $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      $write->save('php://output'); ?> 
</body>
</html>