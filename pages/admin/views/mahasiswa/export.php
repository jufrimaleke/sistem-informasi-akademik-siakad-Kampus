<?php
// Load file koneksi.php

include "../../../../config/fungsi.php";
  


    header("Content-Type:application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename= Daftar Nilai Mahasiswa.xls");

 $


$id_prodi = $_POST["prodi"];
$id_angkatan = $_POST["angkatan"];

$query = mysqli_query($conn, "SELECT * FROM mahasiswa 
          INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
          INNER JOIN angkatan ON mahasiswa.id_angkatan = angkatan.id_angkatan
          WHERE mahasiswa.id_jurusan= $id_prodi AND mahasiswa.id_angkatan = $id_angkatan");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
</head>
<body>
  <table border="1">
    <tr>
    
      <th>Nim</th>
      <th>Nama</th>
      <th>Nik</th>
      <th>Jenis_Kelamin</th>
      <th>Tempat_Lahir</th>
      <th>Tanggal_lahir</th>
      <th>Alamat</th>
      <th>Telepon</th>
      <th>Email</th>
      <th>Agama</th>
      <th>Program_Studi</th>
      <th>Angkatan</th>
    </tr>
    <?php 
      $id_prodi = $_POST["prodi"];
      $id_angkatan = $_POST["angkatan"];

      $query = mysqli_query($conn, "SELECT * FROM mahasiswa 
                INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
                INNER JOIN angkatan ON mahasiswa.id_angkatan = angkatan.id_angkatan
                WHERE mahasiswa.id_jurusan= $id_prodi AND mahasiswa.id_angkatan = $id_angkatan");
      while($data1 = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
     
      <td><?= $data1['nim'] ?></td>
      <td><?= $data1['nama'] ?></td>
      <td><?= $data1['nik'] ?></td>
      <td><?= $data1['jenis_kelamin'] ?></td>
      <td><?= $data1['tempat_lahir'] ?></td>
      <td><?= $data1['tgl_lahir'] ?></td>
      <td><?= $data1['alamat'] ?></td>
      <td><?= $data1['telp'] ?></td>
      <td><?= $data1['email'] ?></td>
      <td><?= $data1['agama'] ?></td>
      <td><?= $data1['nama_jurusan'] ?></td>
      <td><?= $data1['id_angkatan'] ?></td>
    </tr>
  <?php } ?>
  </table>

</body>
</html>