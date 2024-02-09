  <?php 
  if (!isset($_SESSION))session_start();
  include "../../config/fungsi.php";

  $nim = $_GET['nim'];

  

  $querymhs = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim = $nim");
  $rowMhs= mysqli_fetch_assoc($querymhs);

  $semester = mysqli_query($conn, "SELECT * FROM semester WHERE status='1'");
  $row = mysqli_fetch_assoc($semester);

  $jadwal = mysqli_query($conn, "SELECT * FROM jadwal
      INNER JOIN mata_kuliah ON jadwal.id_mk = mata_kuliah.id_mk
      INNER JOIN semester ON jadwal.id_semester = semester.id_semester
      INNER JOIN kelas ON jadwal.id_kelas = kelas.id_kelas
      INNER JOIN dosen ON jadwal.nip = dosen.nip
      INNER JOIN paket_semester ON jadwal.id_paketSemester = paket_semester.id_paket
      WHERE mata_kuliah.id_jurusan = $rowMhs[id_jurusan] AND semester.id_semester = $row[id_semester] AND jadwal.id_semester = '{$row['id_semester']}' ORDER BY jadwal.id_paketSemester ASC");


  $kelas = mysqli_query($conn, "SELECT * FROM kelas");


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
    echo "
      <script>
        alert('data gagal ditambahkan:');
        document.location.href = '?page=krs';
      </script>
    ";
  }


}
 ?> 
 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
   <style type="text/css">
   th { text-align: center; }
   td { padding: 10px;}
   </style>
 </head>
 <body>
 <section class="content-header">
  <h1>
    Dashboard
     <small>Control Panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
     <li><a href="#"> Dashboard</a></li>
      <li class="active"> khs</li>
  </ol> 
</section>

<!-- Main content -->
 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
            <h3>Kartu Rencana Studi</h3>
            <div class="row">
            <div class="col-md-6">
              <form action="" method="POST">
                <div class="form-group">
                  <?php 
                    $mhs = mysqli_query($conn, "SELECT * FROM mahasiswa 
                      INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
                      WHERE mahasiswa.nim = '$nim'");
                   ?>                
                     <?php while ($row = mysqli_fetch_array($mhs)) { ?>                 
                  <input class="form-control select2" readonly="true" value="<?php echo $row['nama'] ?> "/>
                </div>
                <div class="form-group">
                  <input class="form-control select2" name="nim" readonly="true" value="<?php echo $row['nim'] ?> "/>   
                </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <input class="form-control select2" type="hidden" name="prodi" readonly="true"value="<?php echo $row['id_jurusan'] ?>" />
                      <input class="form-control select2" readonly="true" value="<?= $row['nama_jurusan'] ?>">
                         <?php } ?>
                  </div>
                  <div class="form-group">
                     <?php 
                      $semester = mysqli_query($conn, "SELECT * FROM semester WHERE status = '1'");
                     ?>
                      <select class="form-control select2" name="semester"  id="semester" style="width: 100%;" >
                       <?php while ($row = mysqli_fetch_array($semester)) { ?>
                      <option value="<?php echo $row['id_semester'] ?>"><?php echo $row['nama_semester'] ?></option>
                     <?php } ?>
                     </select>
                  </div>  
                </div> 
            </div>
                <div class="form-group">
                      <input type="text" class="form-control" style="text-align: center;" value="KARTU RENCANA STUDI" readonly="">
                </div>
                <table class='table table-hover'>   
                    <tr>
                      <th>Pilih</th>
                      <th>Semester</th>
                      <th>Kode MatKul</th>
                      <th>Mata Kuliah</th>
                      <th>SKS</th>
                      <th>Dosen</th>
                      <th>Hari</th>
                      <th>Jam</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach ($jadwal as $row) : ?>
                    <tr>
                      <td><input type="checkbox" name="cek[]"  value="<?php echo $row['id_jadwal']; ?> "></td>
                      <td><?= $row['nama_paket'] ?></td>
                      <td><?= $row['kode_mk'] ?></td>
                      <td><?= $row['nama_mk'] ?></td>
                      <td><?= $row['sks'] ?></td>
                      <td><?= $row['nama_dosen'] ?></td>
                      <td><?= $row['hari'] ?></td>
                      <td><?= $row["jam_mulai"].' - '.$row["jam_selesai"]; ?></td>
                      <?php $i++; ?>
                      <?php endforeach; ?>
                    </tr>  
                </table>
                 <button type="submit" name="submit" value="tambah" class="btn btn-success btn-ms"><span class="glyphicon glyphicon-plus"></span> Tambah</button>  
                <a href="?page=krs" class="btn btn-danger btn-ms"> Batal </a>
                </div>
              </form>
            </div>
          </div>
           </div>
                </div>
              </div>
            </div>          
  </section>
</body>
</html>




 